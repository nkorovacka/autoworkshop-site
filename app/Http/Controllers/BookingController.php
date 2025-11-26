<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function create()
    {
        return view('booking');
    }

    public function store(Request $request)
    {
        // Validācija
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:50',
            'customer_email'  => 'nullable|email|max:255',

            'car'       => 'required|string',
            'condition' => 'required|string',
            'date'      => 'required|date',
            'time'      => 'required|string',
            'total'     => 'required|numeric|min:0',
            'services'  => 'required|array|min:1',
        ], [
            'services.required' => 'Lūdzu izvēlies vismaz vienu pakalpojumu.',
        ]);

        // Pakalpojumu sarakstu saglabāsim kā tekstu
        $servicesText = implode(', ', $data['services']);

        Booking::create([
            'customer_name'   => $data['customer_name'],
            'customer_phone'  => $data['customer_phone'],
            'customer_email'  => $data['customer_email'] ?? null,

            'car_model'       => $data['car'],
            'condition'       => $data['condition'],
            'date'            => $data['date'],
            'time_slot'       => $data['time'],
            'services'        => $servicesText,
            'total_price'     => $data['total'],
        ]);

        return back()->with('success', 'Pieteikums veiksmīgi saglabāts!');
    }
}
