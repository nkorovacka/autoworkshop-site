<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Offer;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Palīgfunkcija – uzģenerē laika slotus 9:00–20:00 ik pēc 1.5h
    protected function generateTimeSlots(): array
    {
        $slots = [];

        $start = strtotime('09:00');
        $end   = strtotime('20:00');
        $step  = 90 * 60; // 1.5h sekundēs

        for ($t = $start; $t <= $end; $t += $step) {
            $slots[] = date('H:i', $t);
        }

        return $slots;
    }

    public function create(Request $request)
    {
        $offer = null;
        $timeSlots = [];
        $takenSlots = [];

        $offerId = $request->query('offer');

        if ($offerId) {
            $offer = Offer::find($offerId);

            if ($offer && $offer->type === 'detailing' && $offer->has_timeslots) {
                $timeSlots = $this->generateTimeSlots();

                if (!empty($offer->event_date)) {
                    // Aizņemtie laiki šim piedāvājumam konkrētajā datumā
                    $takenSlots = Booking::where('offer_id', $offer->id)
                        ->where('date', $offer->event_date)
                        ->pluck('time_slot')
                        ->toArray();
                }
            }
        }

        return view('booking', [
            'offer'      => $offer,
            'timeSlots'  => $timeSlots,
            'takenSlots' => $takenSlots,
        ]);
    }

    public function store(Request $request)
    {
        // Bāzes validācija
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:50',
            'customer_email'  => 'nullable|email|max:255',

            'car'       => 'required|string',
            'condition' => 'required|string',
            'date'      => 'nullable|date',   // detailing offer gadījumā var tikt ignorēts
            'time'      => 'required|string',
            'total'     => 'required|numeric|min:0',
            'services'  => 'required|array|min:1',
            'offer_id'  => 'nullable|exists:offers,id',
        ], [
            'services.required' => 'Lūdzu izvēlies vismaz vienu pakalpojumu.',
        ]);

        $offer = null;

        if (!empty($data['offer_id'])) {
            $offer = Offer::find($data['offer_id']);
        }

        // Ja ir detailing piedāvājums ar timeslotiem → datumu ņemam no offer.event_date
        if ($offer && $offer->type === 'detailing' && $offer->has_timeslots) {
            $date = $offer->event_date; // fiksēts pasākuma datums
        } else {
            $date = $data['date']; // parastais booking
        }

        $timeSlot = $data['time'];

        // Pārbaudām, vai laiks jau nav aizņemts (vienam un tam pašam offer/datumam)
        $query = Booking::where('date', $date)
            ->where('time_slot', $timeSlot);

        if ($offer) {
            $query->where('offer_id', $offer->id);
        }

        if ($query->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Šis laiks jau ir aizņemts. Lūdzu izvēlies citu laiku.');
        }

        // Pakalpojumu saraksts kā teksts
        $servicesText = implode(', ', $data['services']);

        Booking::create([
            'customer_name'   => $data['customer_name'],
            'customer_phone'  => $data['customer_phone'],
            'customer_email'  => $data['customer_email'] ?? null,
            'car_model'       => $data['car'],
            'condition'       => $data['condition'],
            'date'            => $date,
            'time_slot'       => $timeSlot,
            'services'        => $servicesText,
            'total_price'     => $data['total'],
            'offer_id'        => $offer->id ?? null,
        ]);

        return back()->with('success', 'Pieteikums veiksmīgi saglabāts!');
    }
}
