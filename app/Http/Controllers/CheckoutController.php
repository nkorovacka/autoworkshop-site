<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Parāda apmaksas/checkout lapu ar groza saturu.
     */
    public function index()
    {
        // Ielādē groza vienumus ar produktiem konkrētajam lietotājam.
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Ja grozs ir tukšs, novirza atpakaļ uz grozu ar kļūdas paziņojumu.
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Grozā nav produktu.']);
        }

        // Aprēķina starpsummu.
        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);

        return view('checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Apstrādā pasūtījuma noformēšanu, validē datus un saglabā pasūtījumu.
     */
    public function store(Request $request)
    {
        // Ielādē groza vienumus ar produktiem konkrētajam lietotājam.
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Ja grozs ir tukšs, izvada uz grozu ar kļūdas paziņojumu.
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Grozā nav produktu.']);
        }

        // Validē checkout formā ievadītos datus.
        // Šajā posmā tiek pārbaudīti:
        // - klienta telefona numura formāts,
        // - kartes turētāja vārds,
        // - kartes numura garums,
        // - kartes derīguma termiņa formāts,
        // - CVC koda garums,
        // - piegādes veids,
        // - un papildu piezīmes.
        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => [
                'required',
                'regex:/^\+?\d+$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D/', '', (string) $value);
                    if (strlen($digits) > 13) {
                        $fail('Telefona numurs ir par garu (maks. 13 cipari).');
                    }
                },
            ],
            'card_holder' => ['required','max:255','regex:/^[\pL\s\'\-]+$/u'],
            'card_number' => 'required|digits_between:13,19',
            'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\\/([0-9]{2})$/'],
            'card_cvc'    => 'required|digits_between:3,4',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_phone.regex' => 'Telefona numurs ir par garu vai neatbilstošā formātā (maks. 13 cipari un izvēles +).',
            'card_number.digits_between' => 'Kartes numuram jābūt no 13 līdz 19 cipariem.',
        ]);

        // No kartes derīguma termiņa izdala mēnesi un gadu,
        // lai varētu pārvērst to par pilnvērtīgu datumu un salīdzināt ar šodienu.
        [$expMonth, $expYear] = explode('/', $data['card_expiry']);
        $expYearFull = 2000 + (int) $expYear;
        $expiryDate = Carbon::createFromDate($expYearFull, (int) $expMonth, 1)->endOfMonth();
        $minValidDate = now()->addMonth()->startOfMonth();

        // Kartes derīguma termiņam jābūt vismaz vienu mēnesi uz priekšu,
        // pretējā gadījumā pasūtījuma noformēšana netiek atļauta.
        if ($expiryDate->lt($minValidDate)) {
            return back()
                ->withInput()
                ->withErrors(['card_expiry' => 'Kartes derīguma termiņam jābūt vismaz vienu mēnesi pēc šodienas.']);
        }

        // Ja klients izvēlas piegādi uz adresi,
        // piegādes adreses lauks kļūst obligāts.
        if ($data['shipping_method'] === 'delivery' && empty($data['shipping_address'])) {
            return back()->withInput()->withErrors(['shipping_address' => 'Lūdzu ievadi piegādes adresi.']);
        }

        // Pirms pasūtījuma izveides vēlreiz pārbauda,
        // vai katrs produkts joprojām eksistē un ir pieejams pietiekamā daudzumā.
        // Tas novērš situāciju, kur klients mēģina nopirkt preci,
        // kuras atlikums pa to laiku jau ir samazinājies.
        foreach ($items as $item) {
            if (!$item->product || $item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->withErrors(['cart' => 'Kāds no produktiem vairs nav pieejams nepieciešamajā daudzumā.']);
            }
        }

        // Aprēķina pasūtījuma kopējo summu un kopējo preču skaitu.
        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);
        $totalItems = $items->sum('quantity');

        // Pasūtījuma izveide notiek vienā datubāzes transakcijā.
        // Tas nozīmē: ja kāds no soļiem neizdodas,
        // pasūtījums netiek saglabāts daļēji.
        DB::transaction(function () use ($items, $subtotal, $data, $totalItems) {
            // Sagatavo galvenos pasūtījuma datus, kas tiks ierakstīti orders tabulā.
            $payload = [
                'user_id' => auth()->id(),
                'customer_name' => $data['customer_name']
                    ?? optional(auth()->user())->name
                    ?? 'Nezināms klients',
                'customer_phone' => $data['customer_phone'] ?? null,
                'total_price' => $subtotal,
                'total_items' => $totalItems,
                'status' => 'pending',
                'shipping_method' => $data['shipping_method'],
                'shipping_address' => $data['shipping_method'] === 'delivery' ? $data['shipping_address'] : null,
                'payment_method' => 'card',
                'card_holder' => $data['card_holder'],
                'notes' => $data['notes'] ?? null,
            ];

            // Izveido pašu pasūtījuma ierakstu.
            $order = Order::create($payload);

            // Katram groza produktam izveido pasūtījuma rindu
            // un pēc tam samazina konkrētā produkta atlikumu noliktavā.
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Pēc veiksmīgas pasūtījuma saglabāšanas iztīra lietotāja grozu.
            CartItem::where('user_id', auth()->id())->delete();
        });

        // Pēc checkout pabeigšanas lietotāju novirza uz produktu lapu
        // un parāda veiksmīgas noformēšanas paziņojumu.
        return redirect()->route('products.index')
            ->with('success', 'Paldies! Pasūtījums veiksmīgi noformēts.');
    }
}
