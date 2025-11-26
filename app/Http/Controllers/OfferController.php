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

    // Pieteikšanās tikai WEBINĀRIEM / pasākumiem bez auto
    public function signup(Request $request, Offer $offer)
    {
        // Drošībai – tikai 'webinar' tipa piedāvājumiem
        if ($offer->type !== 'webinar') {
            return back()->with('error', 'Šim piedāvājumam pieteikšanās notiek caur auto rezervāciju.');
        }

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Ja ir limits un jau pilns
        if ($offer->is_limited && $offer->registrations_count >= $offer->capacity) {
            return back()->with('error', 'Šis pasākums jau ir pilns.');
        }

        OfferRegistration::create([
            'offer_id' => $offer->id,
            'user_id'  => null, // nākotnē te varēsi likt auth()->id()
            'name'     => $data['name'],
            'email'    => $data['email'],
        ]);

        // Palielinām skaitītāju
        $offer->increment('registrations_count');

        return back()->with('success', 'Tu esi veiksmīgi pieteicies šim pasākumam!');
    }
}
