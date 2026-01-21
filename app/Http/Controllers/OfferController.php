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
        // Tikai pieteikšanās no reģistrētiem lietotājiem un tikai vebināriem
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Lai pieteiktos vebināram, lūdzu pieslēdzies sistēmai.');
        }

        if ($offer->type !== 'webinar') {
            return back()->with('error', 'Šim piedāvājumam pieteikšanās notiek caur auto rezervāciju.');
        }

        $user = auth()->user();

        if (!$user->email) {
            return back()->with('error', 'Lūdzu pievieno e-pasta adresi profila sadaļā, lai varētu pieteikties.');
        }

        // Ja ir limits un jau pilns
        if ($offer->is_limited && $offer->registrations_count >= $offer->capacity) {
            return back()->with('error', 'Šis pasākums jau ir pilns.');
        }

        OfferRegistration::create([
            'offer_id' => $offer->id,
            'user_id'  => auth()->id(),
            'name'     => $user->name ?? 'Dalībnieks',
            'email'    => $user->email,
        ]);

        // Palielinām skaitītāju
        $offer->increment('registrations_count');

        return back()->with('success', 'Tu esi veiksmīgi pieteicies šim pasākumam!');
    }
}
