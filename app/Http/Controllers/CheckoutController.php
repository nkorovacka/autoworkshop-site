<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Grozā nav produktu.']);
        }

        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);

        return view('checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request)
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Grozā nav produktu.']);
        }

        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'card_holder' => ['required','max:255','regex:/^[\pL\s\'\-]+$/u'],
            'card_number' => 'required|digits_between:13,19',
            'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\\/([0-9]{2})$/'],
            'card_cvc'    => 'required|digits_between:3,4',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        [$expMonth, $expYear] = explode('/', $data['card_expiry']);
        $expYearFull = 2000 + (int) $expYear;
        $expiryDate = Carbon::createFromDate($expYearFull, (int) $expMonth, 1)->endOfMonth();
        $minValidDate = now()->addMonth()->startOfMonth();
        if ($expiryDate->lt($minValidDate)) {
            return back()
                ->withInput()
                ->withErrors(['card_expiry' => 'Kartes derīguma termiņam jābūt vismaz vienu mēnesi pēc šodienas.']);
        }

        if ($data['shipping_method'] === 'delivery' && empty($data['shipping_address'])) {
            return back()->withInput()->withErrors(['shipping_address' => 'Lūdzu ievadi piegādes adresi.']);
        }

        foreach ($items as $item) {
            if (!$item->product || $item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->withErrors(['cart' => 'Kāds no produktiem vairs nav pieejams nepieciešamajā daudzumā.']);
            }
        }

        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);
        $totalItems = $items->sum('quantity');
        $itemsSummary = $items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->name ?? 'Produkts #'.$item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
            ];
        })->values();

        DB::transaction(function () use ($items, $subtotal, $data, $totalItems, $itemsSummary) {
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
                'card_last4' => substr($data['card_number'], -4),
                'items_summary' => $itemsSummary->toJson(),
                'notes' => $data['notes'] ?? null,
            ];

            if (Schema::hasColumn('orders', 'product_id')) {
                $payload['product_id'] = $items->count() === 1
                    ? $items->first()->product_id
                    : null;
            }

            $order = Order::create($payload);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('products.index')
            ->with('success', 'Paldies! Pasūtījums veiksmīgi noformēts.');
    }
}
