<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\OfferRegistration;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ProfileController extends Controller
{
    /**
     * Rāda lietotāja profilu ar pieteikumiem un pasūtījumiem.
     */
    public function show()
    {
        // Pašreizējais lietotājs.
        $user = Auth::user();

        // Vebināru pieteikumi ar piedāvājumu detaļām.
        $webinarRegistrations = $user->offerRegistrations()
            ->with('offer')
            ->latest()
            ->get();

        // Pakalpojumu rezervācijas.
        $serviceBookings = $user->bookings()
            ->with('services')
            ->latest()
            ->get();

        // Pasūtījumi, izņemot atceltos, ar precēm un produktiem.
        $orders = $user->orders()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            })
            ->with('items.product')
            ->latest()
            ->get();

        // Nodod profila datus skata failam.
        return view('auth.profile', compact(
            'user',
            'webinarRegistrations',
            'serviceBookings',
            'orders'
        ));
    }

    /**
     * Atceļ vebināra pieteikumu un koriģē reģistrāciju skaitu.
     */
    public function cancelWebinar(OfferRegistration $registration): RedirectResponse
    {
        // Pārbauda, vai pieteikums pieder lietotājam.
        $this->ensureOwnership($registration);

        // Vebināru var atcelt tikai līdz dienai pirms notikuma.
        if ($registration->offer && $registration->offer->event_date) {
            $eventDate = Carbon::parse($registration->offer->event_date)->startOfDay();
            $today = now()->startOfDay();

            if ($today->greaterThanOrEqualTo($eventDate)) {
                return back()->with('error', 'Vebināru tajā pašā dienā atcelt nevar.');
            }
        }

        // Samazina reģistrāciju skaitu, ja tas ir iespējams.
        if ($registration->offer && $registration->offer->registrations_count > 0) {
            $registration->offer->decrement('registrations_count');
        }

        // Dzēš pieteikumu.
        $registration->delete();

        return back()->with('success', 'Vebināra pieteikums ir atcelts.');
    }

    /**
     * Atceļ pakalpojuma rezervāciju.
     */
    public function cancelBooking(Booking $booking): RedirectResponse
    {
        // Pārbauda, vai rezervācija pieder lietotājam.
        $this->ensureOwnership($booking);

        // Lietotājs var atcelt tikai rezervāciju, kas vēl ir procesā.
        if (($booking->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'Rezervāciju var atcelt tikai tad, kamēr tās statuss ir "Procesā".');
        }

        // Rezervāciju nevar atcelt tajā pašā dienā.
        if ($booking->date) {
            $bookingDate = Carbon::parse($booking->date)->startOfDay();
            $today = now()->startOfDay();

            if ($today->greaterThanOrEqualTo($bookingDate)) {
                return back()->with('error', 'Rezervāciju tajā pašā dienā atcelt nevar.');
            }
        }

        // Dzēš rezervāciju.
        $booking->delete();

        return back()->with('success', 'Rezervācija ir atcelta.');
    }

    /**
     * Atceļ pasūtījumu, atjaunojot noliktavas atlikumu.
     */
    public function cancelOrder(Order $order): RedirectResponse
    {
        // Pārbauda, vai pasūtījums pieder lietotājam.
        $this->ensureOwnership($order);

        // Ja pasūtījums jau ir atcelts, neko nemaina.
        if ($order->status === 'cancelled') {
            return back()->with('error', 'Pasūtījums jau ir atcelts.');
        }
        // Ja pasūtījums jau ir izsūtīts, to nevar atcelt.
        if (in_array($order->status, ['completed', 'shipped'], true)) {
            return back()->with('error', 'Pasūtījumu vairs nevar atcelt, jo tas jau ir izsūtīts.');
        }

        // Ielādē pasūtījuma preces un palielina krājumu.
        $order->loadMissing('items.product');
        $this->adjustStock($order, 'increment');
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pasūtījums ir atcelts.');
    }

    /**
     * Pārbauda, vai modelis pieder pašreizējam lietotājam.
     */
    protected function ensureOwnership($model): void
    {
        // Ja nav īpašnieks, bloķē piekļuvi.
        if ($model->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Pielāgo noliktavas atlikumu pasūtījuma precēm.
     */
    protected function adjustStock(Order $order, string $direction): void
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }

            // Palielina vai samazina krājumu atkarībā no virziena.
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
