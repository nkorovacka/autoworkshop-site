<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Order;
use App\Models\Offer;
use App\Models\OfferRegistration;
use App\Models\Product;
use App\Models\WorkItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'bookings' => Booking::count(),
            'orders' => Order::count(),
            'webinar_registrations' => OfferRegistration::count(),
        ];

        $latestBookings = Booking::latest()->take(5)->get();
        $latestOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestBookings', 'latestOrders'));
    }

    public function bookings()
    {
        $bookings = Booking::latest()->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $booking->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Pieteikuma statuss atjaunināts.');
    }

    public function products()
    {
        $products = Product::orderByDesc('created_at')->get();
        $orders = Order::with(['items.product'])->latest()->paginate(15);

        return view('admin.products', compact('products', 'orders'));
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

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

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        $payload = [
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'supplier' => $data['supplier'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $payload['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($payload);

        return back()->with('success', 'Produkts atjaunināts.');
    }

    public function toggleProduct(Product $product): RedirectResponse
    {
        $product->update([
            'is_visible' => !$product->is_visible,
        ]);

        return back()->with('success', 'Produkta redzamība atjaunināta.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produkts dzēsts.');
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $originalStatus = $order->status ?? 'pending';
        $newStatus = $data['status'];

        $order->loadMissing('items.product');

        if ($originalStatus !== 'cancelled' && $newStatus === 'cancelled') {
            $this->adjustStock($order, 'increment');
        } elseif ($originalStatus === 'cancelled' && $newStatus !== 'cancelled') {
            if (!$this->canDecreaseStock($order)) {
                return back()->with('error', 'Nav pietiekams atlikums, lai atjaunotu pasūtījumu.');
            }
            $this->adjustStock($order, 'decrement');
        }

        $order->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', 'Pasūtījuma statuss atjaunināts.');
    }

    protected function adjustStock(Order $order, string $direction): void
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }

            if ($direction === 'increment') {
                $product->increment('stock', $item->quantity);
            } elseif ($direction === 'decrement') {
                $product->decrement('stock', $item->quantity);
            }
        }
    }

    protected function canDecreaseStock(Order $order): bool
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }
            if ($product->stock < $item->quantity) {
                return false;
            }
        }

        return true;
    }

    public function offers()
    {
        $offers = Offer::orderByDesc('event_date')->get();
        $registrations = OfferRegistration::with('offer', 'user')->latest()->paginate(20);

        return view('admin.offers', compact('offers', 'registrations'));
    }

    public function storeOffer(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'capacity' => 'nullable|integer|min:0',
            'format' => 'required|in:online,in_person',
            'is_limited' => 'nullable|boolean',
        ]);

        if ($request->boolean('is_limited') && empty($data['capacity'])) {
            return back()->withInput()->with('error', 'Norādi vietu skaitu, ja izvēlies ierobežotu pasākumu.');
        }

        if (empty($data['capacity']) && !$request->boolean('confirm_unlimited')) {
            return back()->withInput()->with('error', 'Apstiprini, ka vēlies neierobežotu vietu skaitu.');
        }

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

    public function updateOffer(Request $request, Offer $offer): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'capacity' => 'nullable|integer|min:0',
            'format' => 'required|in:online,in_person',
            'is_limited' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->boolean('is_limited') && empty($data['capacity'])) {
            return back()->withInput()->with('error', 'Norādi vietu skaitu, ja izvēlies ierobežotu pasākumu.');
        }

        if (empty($data['capacity']) && !$request->boolean('confirm_unlimited')) {
            return back()->withInput()->with('error', 'Apstiprini, ka vēlies neierobežotu vietu skaitu.');
        }

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

    public function destroyOffer(Offer $offer): RedirectResponse
    {
        $offer->registrations()->delete();
        $offer->delete();

        return back()->with('success', 'Piedāvājums dzēsts.');
    }

    public function destroyRegistration(OfferRegistration $registration): RedirectResponse
    {
        if ($registration->offer && $registration->offer->registrations_count > 0) {
            $registration->offer->decrement('registrations_count');
        }

        $registration->delete();

        return back()->with('success', 'Pieteikums dzēsts.');
    }

    public function workItems()
    {
        $items = WorkItem::orderBy('position')->get();

        return view('admin.work-items', compact('items'));
    }

    public function storeWorkItem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
            'before_image' => 'nullable|image|max:4096',
            'after_image' => 'nullable|image|max:4096',
        ]);

        $payload = [
            'title' => $data['title'],
            'tag' => $data['tag'] ?? null,
            'description' => $data['description'] ?? null,
            'position' => $data['position'] ?? 0,
            'is_visible' => true,
        ];

        if ($request->hasFile('before_image')) {
            $payload['before_image'] = $request->file('before_image')->store('work-items', 'public');
        }
        if ($request->hasFile('after_image')) {
            $payload['after_image'] = $request->file('after_image')->store('work-items', 'public');
        }

        WorkItem::create($payload);

        return back()->with('success', 'Darbs pievienots.');
    }

    public function updateWorkItem(Request $request, WorkItem $workItem): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
            'before_image' => 'nullable|image|max:4096',
            'after_image' => 'nullable|image|max:4096',
        ]);

        $payload = [
            'title' => $data['title'],
            'tag' => $data['tag'] ?? null,
            'description' => $data['description'] ?? null,
            'position' => $data['position'] ?? $workItem->position,
            'is_visible' => $request->boolean('is_visible'),
        ];

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

        $workItem->update($payload);

        return back()->with('success', 'Darbs atjaunināts.');
    }

    public function destroyWorkItem(WorkItem $workItem): RedirectResponse
    {
        if ($workItem->before_image) {
            Storage::disk('public')->delete($workItem->before_image);
        }
        if ($workItem->after_image) {
            Storage::disk('public')->delete($workItem->after_image);
        }

        $workItem->delete();

        return back()->with('success', 'Darbs dzēsts.');
    }
}
