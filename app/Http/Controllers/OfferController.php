<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferRegistration;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    // Piedāvājumu saraksts
    public function index()
    {
        $offers = Offer::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers', compact('offers'));
    }

    // Pieteikšanās vebināram/pasākumam bez auto
    public function signup(Request $request, Offer $offer)
    {
        // drošībai – tikai webinar tipam
        if ($offer->type !== 'webinar') {
            return back()->with('error', 'Šim piedāvājumam pieteikšanās notiek caur auto booking.');
        }

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // ja ir limits un jau pilns
        if ($offer->is_limited && $offer->registrations_count >= $offer->capacity) {
            return back()->with('error', 'Šis pasākums jau ir pilns.');
        }

        OfferRegistration::create([
            'offer_id' => $offer->id,
            'user_id'  => null, // nākotnē šeit būs auth lietotāja ID
            'name'     => $data['name'],
            'email'    => $data['email'],
        ]);

        // palielinām skaitītāju
        $offer->increment('registrations_count');

        return back()->with('success', 'Tu esi veiksmīgi pieteicies šim pasākumam!');
    }
}
