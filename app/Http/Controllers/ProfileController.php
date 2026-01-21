<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\OfferRegistration;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $webinarRegistrations = $user->offerRegistrations()
            ->with('offer')
            ->latest()
            ->get();

        $serviceBookings = $user->bookings()
            ->latest()
            ->get();

        $orders = $user->orders()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            })
            ->with('items.product')
            ->latest()
            ->get();

        return view('auth.profile', compact(
            'user',
            'webinarRegistrations',
            'serviceBookings',
            'orders'
        ));
    }

    public function cancelWebinar(OfferRegistration $registration): RedirectResponse
    {
        $this->ensureOwnership($registration);

        if ($registration->offer && $registration->offer->registrations_count > 0) {
            $registration->offer->decrement('registrations_count');
        }

        $registration->delete();

        return back()->with('success', 'Vebināra pieteikums ir atcelts.');
    }

    public function cancelBooking(Booking $booking): RedirectResponse
    {
        $this->ensureOwnership($booking);

        $booking->delete();

        return back()->with('success', 'Rezervācija ir atcelta.');
    }

    public function cancelOrder(Order $order): RedirectResponse
    {
        $this->ensureOwnership($order);

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Pasūtījums jau ir atcelts.');
        }

        $order->loadMissing('items.product');
        $this->adjustStock($order, 'increment');
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pasūtījums ir atcelts.');
    }

    protected function ensureOwnership($model): void
    {
        if ($model->user_id !== Auth::id()) {
            abort(403);
        }
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
                $decrementBy = min($item->quantity, $product->stock);
                if ($decrementBy > 0) {
                    $product->decrement('stock', $decrementBy);
                }
            }
        }
    }
}
