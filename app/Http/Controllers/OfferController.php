<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferRegistration;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Parāda aktīvo piedāvājumu sarakstu publiskajā lapā.
     */
    public function index()
    {
        // Ielādē tikai aktīvos piedāvājumus, jaunākos rādot vispirms.
        $offers = Offer::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offers', compact('offers'));
    }

    /**
     * Reģistrē lietotāju vebināram/pasākumam (tikai "webinar" tipa piedāvājumiem).
     */
    public function signup(Request $request, Offer $offer)
    {
        // Pieteikšanās atļauta tikai autentificētiem lietotājiem.
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Lai pieteiktos vebināram, lūdzu pieslēdzies sistēmai.');
        }

        // Aizsardzība: reģistrācija tikai "webinar" tipa piedāvājumiem.
        if ($offer->type !== 'webinar') {
            return back()->with('error', 'Šim piedāvājumam pieteikšanās notiek caur auto rezervāciju.');
        }

        $user = auth()->user();

        // E-pasts ir obligāts, lai sazinātos par pasākumu.
        if (!$user->email) {
            return back()->with('error', 'Lūdzu pievieno e-pasta adresi profila sadaļā, lai varētu pieteikties.');
        }

        // Ja ir limits un jau pilns, jaunas reģistrācijas nepieņem.
        if ($offer->is_limited && $offer->registrations_count >= $offer->capacity) {
            return back()->with('error', 'Šis pasākums jau ir pilns.');
        }

        // Izveido dalībnieka reģistrāciju piedāvājumam.
        OfferRegistration::create([
            'offer_id' => $offer->id,
            'user_id'  => auth()->id(),
            'name'     => $user->name ?? 'Dalībnieks',
            'email'    => $user->email,
        ]);

        // Palielina reģistrāciju skaitītāju piedāvājumā.
        $offer->increment('registrations_count');

        return back()->with('success', 'Tu esi veiksmīgi pieteicies šim pasākumam!');
    }
}
