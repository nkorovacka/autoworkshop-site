<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Palīgfunkcija: izveido laika slotus norādītajā intervālā.
     */
    protected function generateTimeSlots(int $stepMinutes = 90, string $startTime = '09:00', string $endTime = '20:00'): array
    {
        $slots = [];

        // Pārveido sākuma/beigu laikus uz timestamp un aprēķina soļa sekundes.
        $start = strtotime($startTime);
        $end   = strtotime($endTime);
        $step  = max($stepMinutes, 1) * 60;

        // Ģenerē slotus līdz norādītajam beigu laikam (ieskaitot).
        for ($t = $start; $t <= $end; $t += $step) {
            $slots[] = date('H:i', $t);
        }

        return $slots;
    }

    /**
     * Parāda rezervācijas formu ar pieejamajiem pakalpojumiem un laikiem.
     */
    public function create(Request $request)
    {
        // Noklusētās vērtības gadījumam, ja piedāvājums nav izvēlēts.
        $offer = null;
        $timeSlots = [];
        $takenSlots = [];

        // Piedāvājuma ID var būt padots kā query parametrs.
        $offerId = $request->query('offer');

        if ($offerId) {
            $offer = Offer::find($offerId);

            if ($offer && $offer->type === 'detailing' && $offer->has_timeslots) {
                // Detailing piedāvājumam ielādējam laika slotus.
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

        // Pakalpojumi un transportlīdzekļu modeļi, kas tiek rādīti formā.
        $services = Service::orderBy('base_price')->get();
        $vehicles = config('vehicles.models', []);
        // Vispārējie laiki parastiem pieteikumiem (2h soli).
        $generalTimeSlots = $this->generateTimeSlots(120, '09:00', '19:00');
        // Minimālais rezervācijas datums ir rītdiena.
        $minBookingDate = Carbon::tomorrow()->format('Y-m-d');

        // Ielādē aizņemtos laikus tuvāko 2 mēnešu periodā.
        $generalBookedSlots = Booking::whereNull('offer_id')
            ->whereBetween('date', [Carbon::today()->format('Y-m-d'), Carbon::today()->copy()->addMonths(2)->format('Y-m-d')])
            ->get()
            ->groupBy('date')
            ->map(function ($items) {
                return $items->pluck('time_slot')->unique()->values();
            })
            ->toArray();

        return view('booking', [
            'offer'      => $offer,
            'timeSlots'  => $timeSlots,
            'takenSlots' => $takenSlots,
            'services'   => $services,
            'vehicles'   => $vehicles,
            'generalTimeSlots' => $generalTimeSlots,
            'generalBookedSlots' => $generalBookedSlots,
            'minBookingDate' => $minBookingDate,
        ]);
    }

    /**
     * Saglabā jaunu rezervāciju, validē izvēles un nodrošina laika pieejamību.
     */
    public function store(Request $request)
    {
        // Bāzes validācija (obligātie lauki, formāti, vērtību ierobežojumi).
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => [
                'required',
                'regex:/^\+?\d+$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D/', '', (string) $value);
                    if (strlen($digits) > 13) {
                        $fail('Telefona numurs ir par garu (maks. 13 cipari).');
                    }
                },
            ],
            'customer_email'  => 'nullable|email|max:255',

            'car'                => 'required|string',
            'condition'          => 'required|string|in:normal,dirty,very_dirty',
            'interior_material'  => 'nullable|string|in:fabric,leather,alcantara',
            'interior_condition' => 'nullable|string|in:fresh,used,dirty',
            'date'               => 'nullable|date',   // detailing offer gadījumā var tikt ignorēts
            'time'               => 'required|string',
            'total'              => 'required|numeric|min:0',
            'services'           => 'required|array|min:1',
            'offer_id'           => 'nullable|exists:offers,id',
        ], [
            'services.required' => 'Lūdzu izvēlies vismaz vienu pakalpojumu.',
            'customer_phone.regex' => 'Telefona numurs ir par garu vai neatbilstošā formātā (maks. 13 cipari un izvēles +).',
        ]);

        // Piedāvājuma objekts, ja rezervācija ir sasaistīta ar akciju.
        $offer = null;

        // Pakalpojumi, kuri nav kombinējami ar citiem.
        $exclusiveServices = [
            'pilns-detailing-komplekts',
            'vip-programma',
        ];
        // Pakalpojumi, kuri prasa salona materiāla/stāvokļa informāciju.
        $interiorServices = [
            'salona-dzila-tirisana',
            'pilns-detailing-komplekts',
            'vip-programma',
        ];
        // Izvēlēto pakalpojumu sadalīšana ekskluzīvajos un standarta.
        $selectedExclusive = array_values(array_intersect($data['services'], $exclusiveServices));
        $standardSelected = array_values(array_diff($data['services'], $exclusiveServices));

        // Ja izvēlēti vairāki ekskluzīvie pakalpojumi, bloķē rezervāciju.
        if (count($selectedExclusive) > 1) {
            return back()
                ->withInput()
                ->with('error', 'Pilnais detailing komplekts un VIP programma jārezervē atsevišķi.');
        }

        // Ekskluzīvie pakalpojumi nedrīkst kombinēties ar citiem.
        if (count($selectedExclusive) === 1 && count($standardSelected) > 0) {
            return back()
                ->withInput()
                ->with('error', 'VIP programma un pilnais detailing komplekts nav kombinējami ar citiem pakalpojumiem.');
        }

        // Nosaka, vai nepieciešami salona detaļu lauki.
        $requiresInteriorDetails = count(array_intersect($data['services'], $interiorServices)) > 0;

        if ($requiresInteriorDetails) {
            // Ja nepieciešams, obligāti jānorāda salona materiāls un stāvoklis.
            if (empty($data['interior_material']) || empty($data['interior_condition'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Lūdzu norādi salona materiālu un stāvokli šim pakalpojumam.');
            }
        } else {
            // Ja nav nepieciešams, atbrīvo no šiem laukiem.
            $data['interior_material'] = null;
            $data['interior_condition'] = null;
        }

        // Ja padots piedāvājuma ID, ielādējam piedāvājumu.
        if (!empty($data['offer_id'])) {
            $offer = Offer::find($data['offer_id']);
        }

        // Nosaka, vai rezervācija ir piesaistīta detailing piedāvājumam ar fiksētiem laikiem.
        $isOfferSchedule = $offer && $offer->type === 'detailing' && $offer->has_timeslots;

        // Parastām rezervācijām datums ir obligāts.
        if (!$isOfferSchedule && empty($data['date'])) {
            return back()
                ->withInput()
                ->with('error', 'Lūdzu izvēlies rezervācijas datumu darba dienā.');
        }

        if (!$isOfferSchedule && !empty($data['date'])) {
            $requestedDate = Carbon::parse($data['date']);
            $tomorrow = Carbon::tomorrow();

            // Brīvdienās rezervācijas netiek pieņemtas.
            if ($requestedDate->isWeekend()) {
                return back()
                    ->withInput()
                    ->with('error', 'Brīvdienās nestrādājam. Lūdzu izvēlies datumu no pirmdienas līdz piektdienai.');
            }

            // Rezervācijas atļautas tikai no rītdienas.
            if ($requestedDate->lessThan($tomorrow)) {
                return back()
                    ->withInput()
                    ->with('error', 'Rezervācijas iespējamas tikai sākot ar rītdienu.');
            }
        }

        // Atļautie laiki atšķiras piedāvājumiem un parastajiem pieteikumiem.
        $allowedTimes = $isOfferSchedule
            ? $this->generateTimeSlots()
            : $this->generateTimeSlots(120, '09:00', '19:00');

        // Ja izvēlētais laiks nav atļauto sarakstā, atgriež kļūdu.
        if (!in_array($data['time'], $allowedTimes, true)) {
            $errorMessage = $isOfferSchedule
                ? 'Izvēlētais laiks nav pieejams šim piedāvājumam.'
                : 'Laiku var rezervēt no 09:00 līdz 19:00 ar soli 2h.';

            return back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Ja ir detailing piedāvājums ar timeslotiem, datumu ņem no piedāvājuma.
        if ($isOfferSchedule) {
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

        // Ja atrasts konflikts, liek izvēlēties citu laiku.
        if ($query->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Šis laiks jau ir aizņemts. Lūdzu izvēlies citu laiku.');
        }

        // Pakalpojumu saraksts kā teksts
        $servicesText = implode(', ', $data['services']);

        // Saglabā rezervāciju ar statusu "pending".
        Booking::create([
            'user_id'        => auth()->id(),
            'customer_name'   => $data['customer_name'],
            'customer_phone'  => $data['customer_phone'],
            'customer_email'  => $data['customer_email'] ?? null,
            'car_model'       => $data['car'],
            'condition'       => $data['condition'],
            'interior_material' => $data['interior_material'] ?? null,
            'interior_condition' => $data['interior_condition'] ?? null,
            'date'            => $date,
            'time_slot'       => $timeSlot,
            'services'        => $servicesText,
            'total_price'     => $data['total'],
            'status'          => 'pending',
            'offer_id'        => $offer->id ?? null,
        ]);

        return back()->with('success', 'Pieteikums veiksmīgi saglabāts!');
    }

}
