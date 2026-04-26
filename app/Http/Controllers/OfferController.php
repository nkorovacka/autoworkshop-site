<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\OfferRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OfferController extends Controller
{
    /**
     * Parāda aktīvo piedāvājumu sarakstu publiskajā lapā.
     */
    public function index()
    {
        // Ielādē tikai aktīvos piedāvājumus, jaunākos rādot vispirms.
        $offers = Offer::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('event_date')
                    ->orWhereDate('event_date', '>', Carbon::today()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $registeredOfferIds = auth()->check()
            ? OfferRegistration::where('user_id', auth()->id())->pluck('offer_id')->all()
            : [];

        return view('offers', compact('offers', 'registeredOfferIds'));
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

        // Validē pieteikšanās formā ievadītos datus.
        // Lietotājam jānorāda vārds un derīga e-pasta adrese.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ], [
            'name.required' => 'Lūdzu ievadi vārdu un uzvārdu.',
            'email.required' => 'Lūdzu ievadi e-pasta adresi.',
            'email.email' => 'Nepareizs e-pasta formāts.',
        ]);

        // Ja vebināra datums jau ir pienācis vai pagājis,
        // jaunas pieteikšanās vairs nav atļautas.
        if ($offer->event_date && Carbon::parse($offer->event_date)->startOfDay()->lessThanOrEqualTo(Carbon::today())) {
            return back()->with('error', 'Pieteikšanās šim vebināram vairs nav pieejama.');
        }

        $userId = auth()->id();

        // Pārbauda, vai lietotājs uz šo pašu vebināru jau nav pieteicies iepriekš.
        if (OfferRegistration::where('offer_id', $offer->id)->where('user_id', $userId)->exists()) {
            return back()->with('error', 'Tu jau esi pieteicies šim vebināram.');
        }

        try {
            DB::transaction(function () use ($offer, $data, $userId) {
                // Bloķē konkrēto piedāvājuma ierakstu transakcijas laikā,
                // lai vienlaikus vairāki lietotāji nevarētu pārsniegt vietu limitu.
                $lockedOffer = Offer::query()->lockForUpdate()->findOrFail($offer->id);

                // Drošības pārbaude transakcijas iekšpusē:
                // ja cits pieprasījums paspēja lietotāju piereģistrēt ātrāk,
                // atkārtotu pieteikumu vairs neveido.
                if (OfferRegistration::where('offer_id', $lockedOffer->id)->where('user_id', $userId)->exists()) {
                    throw new RuntimeException('already_registered');
                }

                // Ja vebināram ir dalībnieku limits un tas jau ir sasniegts,
                // jaunas reģistrācijas nepieņem.
                if ($lockedOffer->is_limited && $lockedOffer->capacity && $lockedOffer->registrations_count >= $lockedOffer->capacity) {
                    throw new RuntimeException('full');
                }

                // Izveido jaunu pieteikuma ierakstu offer_registrations tabulā.
                OfferRegistration::create([
                    'offer_id' => $lockedOffer->id,
                    'user_id'  => $userId,
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                ]);

                // Palielina pieteikto dalībnieku skaitu,
                // lai publiskajā lapā un administratora panelī būtu redzams aktuālais skaits.
                $lockedOffer->increment('registrations_count');
            });
        } catch (RuntimeException $exception) {
            // Ja transakcijas laikā tika konstatēts,
            // ka lietotājs jau ir pieteicies, atgriež attiecīgu kļūdu.
            if ($exception->getMessage() === 'already_registered') {
                return back()->with('error', 'Tu jau esi pieteicies šim vebināram.');
            }

            // Ja vietu limits ir sasniegts, atgriež paziņojumu par pilnu pasākumu.
            if ($exception->getMessage() === 'full') {
                return back()->with('error', 'Šis pasākums jau ir pilns.');
            }

            throw $exception;
        }

        // Veiksmīgas pieteikšanās gadījumā atgriež lietotāju atpakaļ
        // ar apstiprinājuma paziņojumu.
        return back()->with('success', 'Tu esi veiksmīgi pieteicies šim pasākumam!');
    }
}
