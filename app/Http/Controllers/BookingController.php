<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        // Šeit varētu ielikt arī carOptions no atsevišķa faila, bet eksāmenam vari turēt Blade'ā
        return view('booking');
    }

    public function store(Request $request)
    {
        // Validācija
        $data = $request->validate([
            'car'       => 'required|string',
            'condition' => 'required|string',
            'material'  => 'nullable|string',
            'date'      => 'required|date',
            'time'      => 'required|string',
            'total'     => 'required|numeric|min:0',
            'services'  => 'required|array|min:1',
        ], [
            'services.required' => 'Lūdzu izvēlies vismaz vienu pakalpojumu.',
        ]);

        // Ja interjers, tad materiālam jābūt
        if (in_array('interior', $data['services']) && empty($data['material'])) {
            return back()
                ->withInput()
                ->withErrors(['material' => 'Ja izvēlēts salona pakalpojums, jānorāda materiāls.']);
        }

        // Pārbaudām, vai laiks jau aizņemts
        $exists = Booking::where('date', $data['date'])
            ->where('time_slot', $data['time'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'Šis laiks jau ir aizņemts!']);
        }

        // Ja tev ir autentifikācija, var lietot auth()->id()
        $userId = auth()->id(); // vai null, ja nav login sistēmas

        Booking::create([
            'user_id'     => $userId,
            'car_model'   => $data['car'],
            'condition'   => $data['condition'],
            'material'    => $data['material'] ?? null,
            'date'        => $data['date'],
            'time_slot'   => $data['time'],
            'total_price' => $data['total'],
        ]);

        // Te varētu arī saglabāt services atsevišķā tabulā (booking_services), ja grib
        // eksāmenam pietiek ar kopējo summu un info

        return redirect()->route('booking.create')->with('success', 'Pieteikums veiksmīgi saglabāts!');
    }
}
