<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Order;
use App\Models\Offer;
use App\Models\OfferRegistration;
use App\Models\Product;
use App\Models\User;
use App\Models\WorkItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as ValidationPassword;

class AdminController extends Controller
{
    /**
     * Parāda pieteikumu sarakstu ar lapošanu.
     */
    public function bookings()
    {
        // Pēdējie pieteikumi, sadalīti lapās.
        $bookings = Booking::latest()->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Atjaunina pieteikuma statusu (apstiprināts/atteikts/gaida).
     */
    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        // Validē pieļaujamos statusus, lai nepieļautu nekorektus datus.
        $data = $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        // Saglabā jauno statusu datubāzē.
        $booking->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Pieteikuma statuss atjaunināts.');
    }

    /**
     * Admin produkti un ar tiem saistītie pasūtījumi.
     */
    public function products()
    {
        // Visi produkti pārskatīšanai, jaunākie augšā.
        $products = Product::orderByDesc('created_at')->get();
        // Pasūtījumi ar precēm, lai uzreiz redzētu pasūtījuma sastāvu.
        $orders = Order::with(['items.product'])->latest()->paginate(15);

        return view('admin.products', compact('products', 'orders'));
    }

    /**
     * Parāda lietotāju sarakstu ar iespēju rediģēt un dzēst.
     */
    public function users()
    {
        // Ielādē lietotājus ar lapošanu ērtākai pārskatīšanai.
        $users = User::orderByDesc('created_at')->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Atjaunina lietotāja datus un pēc izvēles nomaina paroli.
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        // Validē pamatlaukus, kā arī unikālu e-pastu un paroles sarežģītību.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'is_admin' => ['required', 'boolean'],
            'password' => [
                'nullable',
                'confirmed',
                ValidationPassword::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        // Sagatavo atjaunināmo datu masīvu bez paroles, ja tā nav ievadīta.
        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => $data['is_admin'],
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        // Saglabā izmaiņas datubāzē.
        $user->update($payload);

        return back()->with('success', 'Lietotāja dati atjaunināti.');
    }

    /**
     * Dzēš lietotāju, aizliedzot dzēst pašam sevi vai pēdējo adminu.
     */
    public function destroyUser(User $user): RedirectResponse
    {
        // Neļauj dzēst pašreizējo adminu.
        if (auth()->id() === $user->id) {
            return back()->withErrors(['delete' => 'Nevar dzēst pašreiz pieslēgto adminu.']);
        }

        // Aizsardzība: nedzēš pēdējo adminu sistēmā.
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->withErrors(['delete' => 'Nevar dzēst pēdējo adminu sistēmā.']);
        }

        $user->delete();

        return back()->with('success', 'Lietotājs dzēsts.');
    }

    /**
     * Izveido jaunu produktu, ja dati ir korekti un attēls validēts.
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        // Validē ievades datus un failu ierobežojumus.
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        // Saglabā attēlu, ja tas ir augšupielādēts.
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Izveido jaunu produktu ar noklusējuma redzamību.
        Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'supplier' => $data['supplier'] ?? null,
            'image' => $imagePath,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Produkts pievienots.');
    }

    /**
     * Atjaunina esoša produkta datus un, ja nepieciešams, arī attēlu.
     */
    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        // Validē ievades laukus un attēla tipu/izmēru.
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        // Sagatavo datu masīvu atjaunināšanai.
        $payload = [
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'supplier' => $data['supplier'] ?? null,
        ];

        // Ja pievienots jauns attēls, dzēš veco un saglabā jauno.
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $payload['image'] = $request->file('image')->store('products', 'public');
        }

        // Saglabā izmaiņas datubāzē.
        $product->update($payload);

        return back()->with('success', 'Produkts atjaunināts.');
    }

    /**
     * Pārslēdz produkta redzamību publiskajā katalogā.
     */
    public function toggleProduct(Product $product): RedirectResponse
    {
        // Apgriež esošo redzamības stāvokli.
        $product->update([
            'is_visible' => !$product->is_visible,
        ]);

        return back()->with('success', 'Produkta redzamība atjaunināta.');
    }

    /**
     * Dzēš produktu un saistīto attēlu no diska.
     */
    public function destroyProduct(Product $product): RedirectResponse
    {
        // Noņem attēla failu, lai nepaliek lieki resursi.
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Dzēš produktu no datubāzes.
        $product->delete();

        return back()->with('success', 'Produkts dzēsts.');
    }

    /**
     * Atjaunina pasūtījuma statusu un koriģē krājumu, ja pasūtījums atcelts/atjaunots.
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        // Atļautie statusi, lai uzturētu konsekvenci.
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        // Fiksē sākotnējo un jauno statusu salīdzināšanai.
        $originalStatus = $order->status ?? 'pending';
        $newStatus = $data['status'];

        // Ielādē pasūtījuma preces krājumu korekcijām.
        $order->loadMissing('items.product');

        // Ja pasūtījumu atceļ, krājums jāatgriež noliktavā.
        if ($originalStatus !== 'cancelled' && $newStatus === 'cancelled') {
            $this->adjustStock($order, 'increment');
        // Ja pasūtījumu atjauno, krājums jānoņem no noliktavas.
        } elseif ($originalStatus === 'cancelled' && $newStatus !== 'cancelled') {
            if (!$this->canDecreaseStock($order)) {
                return back()->with('error', 'Nav pietiekams atlikums, lai atjaunotu pasūtījumu.');
            }
            $this->adjustStock($order, 'decrement');
        }

        // Saglabā jauno statusu.
        $order->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', 'Pasūtījuma statuss atjaunināts.');
    }

    /**
     * Pielāgo krājumu uz augšu vai leju visām pasūtījuma precēm.
     */
    protected function adjustStock(Order $order, string $direction): void
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }

            // Palielina vai samazina noliktavas atlikumu.
            if ($direction === 'increment') {
                $product->increment('stock', $item->quantity);
            } elseif ($direction === 'decrement') {
                $product->decrement('stock', $item->quantity);
            }
        }
    }

    /**
     * Pārbauda, vai visām pasūtījuma precēm pietiek krājuma samazināšanai.
     */
    protected function canDecreaseStock(Order $order): bool
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }
            // Ja kādai precei nepietiek, atjaunošana nav iespējama.
            if ($product->stock < $item->quantity) {
                return false;
            }
        }

        return true;
    }

    /**
     * Rāda piedāvājumus un reģistrācijas.
     */
    public function offers()
    {
        // Piedāvājumi sakārtoti pēc datuma, reģistrācijas ar lietotāja datiem.
        $offers = Offer::orderByDesc('event_date')->get();
        $registrations = OfferRegistration::with('offer', 'user')->latest()->paginate(20);

        return view('admin.offers', compact('offers', 'registrations'));
    }

    /**
     * Izveido jaunu piedāvājumu (piem., tiešsaistes webināru).
     */
    public function storeOffer(Request $request): RedirectResponse
    {
        // Validē ievadi un datuma/formatu prasības.
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'capacity' => 'nullable|integer|min:0',
            'format' => 'required|in:online,in_person',
            'is_limited' => 'nullable|boolean',
        ]);

        // Ja pasākums ir ierobežots, vietu skaits ir obligāts.
        if ($request->boolean('is_limited') && empty($data['capacity'])) {
            return back()->withInput()->with('error', 'Norādi vietu skaitu, ja izvēlies ierobežotu pasākumu.');
        }

        // Ja vietu skaits nav norādīts, nepieciešams apstiprinājums par neierobežotību.
        if (empty($data['capacity']) && !$request->boolean('confirm_unlimited')) {
            return back()->withInput()->with('error', 'Apstiprini, ka vēlies neierobežotu vietu skaitu.');
        }

        // Saglabā jauno piedāvājumu ar noklusējuma parametriem.
        Offer::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'event_date' => $data['event_date'] ?? null,
            'capacity' => $data['capacity'] ?? null,
            'is_limited' => $request->boolean('is_limited'),
            'registrations_count' => 0,
            'type' => 'webinar',
            'format' => $data['format'],
            'has_timeslots' => false,
            'is_active' => true,
        ]);

        return back()->with('success', 'Piedāvājums pievienots.');
    }

    /**
     * Atjaunina piedāvājuma datus un pieejamību.
     */
    public function updateOffer(Request $request, Offer $offer): RedirectResponse
    {
        // Validē ievades laukus un statusa norādes.
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'capacity' => 'nullable|integer|min:0',
            'format' => 'required|in:online,in_person',
            'is_limited' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Ja pasākums ir ierobežots, vietu skaits ir obligāts.
        if ($request->boolean('is_limited') && empty($data['capacity'])) {
            return back()->withInput()->with('error', 'Norādi vietu skaitu, ja izvēlies ierobežotu pasākumu.');
        }

        // Ja vietu skaits nav norādīts, nepieciešams apstiprinājums par neierobežotību.
        if (empty($data['capacity']) && !$request->boolean('confirm_unlimited')) {
            return back()->withInput()->with('error', 'Apstiprini, ka vēlies neierobežotu vietu skaitu.');
        }

        // Saglabā izmaiņas piedāvājumam.
        $offer->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'event_date' => $data['event_date'] ?? null,
            'capacity' => $data['capacity'] ?? null,
            'format' => $data['format'],
            'is_limited' => $request->boolean('is_limited'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Piedāvājums atjaunināts.');
    }

    /**
     * Dzēš piedāvājumu un tā reģistrācijas.
     */
    public function destroyOffer(Offer $offer): RedirectResponse
    {
        // Noņem saistītās reģistrācijas, lai netiek atstātas bāreņa rindas.
        $offer->registrations()->delete();
        $offer->delete();

        return back()->with('success', 'Piedāvājums dzēsts.');
    }

    /**
     * Dzēš konkrētu reģistrāciju un koriģē skaitītāju.
     */
    public function destroyRegistration(OfferRegistration $registration): RedirectResponse
    {
        // Samazina reģistrāciju skaitu, ja ir piesaistīts piedāvājums.
        if ($registration->offer && $registration->offer->registrations_count > 0) {
            $registration->offer->decrement('registrations_count');
        }

        // Dzēš pašu reģistrāciju.
        $registration->delete();

        return back()->with('success', 'Pieteikums dzēsts.');
    }

    /**
     * Parāda "mūsu darbi" vienumus sakārtotus pēc pozīcijas.
     */
    public function workItems()
    {
        // Ielādē visus vienumus, lai admin var tos pārkārtot.
        $items = WorkItem::orderBy('position')->get();

        return view('admin.work-items', compact('items'));
    }

    /**
     * Izveido jaunu "mūsu darbi" vienumu ar attēliem.
     */
    public function storeWorkItem(Request $request): RedirectResponse
    {
        // Validē laukus un attēlu failu ierobežojumus.
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
            'before_image' => 'nullable|image|max:4096',
            'after_image' => 'nullable|image|max:4096',
        ]);

        // Sagatavo datu masīvu izveidei ar noklusējuma vērtībām.
        $payload = [
            'title' => $data['title'],
            'tag' => $data['tag'] ?? null,
            'description' => $data['description'] ?? null,
            'position' => $data['position'] ?? 0,
            'is_visible' => true,
        ];

        // Saglabā "pirms" un "pēc" attēlus, ja tie pievienoti.
        if ($request->hasFile('before_image')) {
            $payload['before_image'] = $request->file('before_image')->store('work-items', 'public');
        }
        if ($request->hasFile('after_image')) {
            $payload['after_image'] = $request->file('after_image')->store('work-items', 'public');
        }

        // Izveido jaunu darba vienumu.
        WorkItem::create($payload);

        return back()->with('success', 'Darbs pievienots.');
    }

    /**
     * Atjaunina "mūsu darbi" vienumu un nomaina attēlus, ja tie tiek augšupielādēti.
     */
    public function updateWorkItem(Request $request, WorkItem $workItem): RedirectResponse
    {
        // Validē ievades datus un attēlu failus.
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
            'before_image' => 'nullable|image|max:4096',
            'after_image' => 'nullable|image|max:4096',
        ]);

        // Sagatavo atjaunināmo datu masīvu.
        $payload = [
            'title' => $data['title'],
            'tag' => $data['tag'] ?? null,
            'description' => $data['description'] ?? null,
            'position' => $data['position'] ?? $workItem->position,
            'is_visible' => $request->boolean('is_visible'),
        ];

        // Nomaina "pirms" attēlu, dzēšot veco failu.
        if ($request->hasFile('before_image')) {
            if ($workItem->before_image) {
                Storage::disk('public')->delete($workItem->before_image);
            }
            $payload['before_image'] = $request->file('before_image')->store('work-items', 'public');
        }
        if ($request->hasFile('after_image')) {
            if ($workItem->after_image) {
                Storage::disk('public')->delete($workItem->after_image);
            }
            $payload['after_image'] = $request->file('after_image')->store('work-items', 'public');
        }

        // Saglabā izmaiņas datubāzē.
        $workItem->update($payload);

        return back()->with('success', 'Darbs atjaunināts.');
    }

    /**
     * Dzēš "mūsu darbi" vienumu un saistītos attēlus no diska.
     */
    public function destroyWorkItem(WorkItem $workItem): RedirectResponse
    {
        // Dzēš attēlus, ja tie eksistē, lai neatstātu liekus failus.
        if ($workItem->before_image) {
            Storage::disk('public')->delete($workItem->before_image);
        }
        if ($workItem->after_image) {
            Storage::disk('public')->delete($workItem->after_image);
        }

        // Dzēš vienumu no datubāzes.
        $workItem->delete();

        return back()->with('success', 'Darbs dzēsts.');
    }
}
