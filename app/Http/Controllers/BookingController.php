<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Palīgfunkcija: izveido laika slotus norādītajā intervālā.
     */
    protected function generateTimeSlots(int $stepMinutes = 90, string $startTime = '09:00', string $endTime = '20:00'): array
    {
        // Šajā masīvā pakāpeniski tiks uzkrāti visi pieejamie laika sloti.
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
        // Ielādē visus pakalpojumus, sakārtojot tos pēc sākumcenas augošā secībā.
        // Šie dati tiek izmantoti rezervācijas formas pakalpojumu izvēles blokā.
        $services = Service::orderBy('base_price')->get();

        // Nolasa automašīnu modeļus no konfigurācijas faila.
        // Tie tiek izmantoti auto modeļa laukā, lai lietotājs izvēlētos tikai atļautu vērtību.
        $vehicles = config('vehicles.models', []);

        // Izveido pieejamo laiku sarakstu rezervācijām.
        // Šajā projektā klientiem tiek piedāvāti laiki ar 2 stundu soli no 09:00 līdz 19:00.
        $generalTimeSlots = $this->generateTimeSlots(120, '09:00', '19:00');

        // Rezervāciju drīkst veikt tikai sākot ar nākamo dienu,
        // tāpēc formai nododam minimāli atļauto datumu.
        $minBookingDate = Carbon::tomorrow()->format('Y-m-d');

        // Ielādē jau aizņemtos laikus tuvākajiem diviem mēnešiem.
        // Šī informācija frontendā ļauj uzreiz atspējot rezervētos laikus,
        // negaidot formas iesniegšanu.
        $generalBookedSlots = Booking::whereBetween('date', [Carbon::today()->format('Y-m-d'), Carbon::today()->copy()->addMonths(2)->format('Y-m-d')])
            ->get()
            ->groupBy('date')
            ->map(function ($items) {
                // Katram datumam saglabājam unikālu aizņemto laiku sarakstu.
                return $items->pluck('time_slot')->unique()->values();
            })
            ->toArray();

        return view('booking', [
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
        // Veic sākotnējo servera puses validāciju visiem formas laukiem.
        // Šajā posmā tiek pārbaudīti:
        // - obligātie lauki,
        // - datu tipi,
        // - atļautās vērtības,
        // - pakalpojumu masīva struktūra,
        // - kā arī telefona numura formāts un maksimālais garums.
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => [
                'required',
                'regex:/^\+?\d+$/',
                function ($attribute, $value, $fail) {
                    // Papildus regex pārbaudei tiek saskaitīti tikai cipari,
                    // lai nepieļautu pārāk garu telefona numuru.
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
            'date'               => 'required|date',
            'time'               => 'required|string',
            'total'              => 'required|numeric|min:0',
            'services'           => 'required|array|min:1',
            'services.*'         => 'integer|exists:services,id',
        ], [
            'services.required' => 'Lūdzu izvēlies vismaz vienu pakalpojumu.',
            'customer_phone.regex' => 'Telefona numurs ir par garu vai neatbilstošā formātā (maks. 13 cipari un izvēles +).',
        ]);

        // Savāc izvēlēto pakalpojumu ID, pārvērš tos uz integer,
        // izmet dublikātus un nodrošina konsekventu secību.
        $selectedServiceIds = collect($data['services'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        // Ielādē visus izvēlētos pakalpojumus no datubāzes un indeksē tos pēc ID.
        // Tas ļauj vēlāk ātri piekļūt pakalpojuma slugam vai citai informācijai.
        $selectedServices = Service::whereIn('id', $selectedServiceIds)->get()->keyBy('id');

        // No izvēlētajiem pakalpojumiem iegūstam slugus,
        // jo tieši ar tiem tiek definēti biznesa noteikumi.
        // Piemēram, VIP programma un pilnais komplekts tiek atpazīti pēc sluga, nevis nosaukuma.
        $selectedServiceSlugs = $selectedServiceIds
            ->map(fn ($id) => optional($selectedServices->get($id))->slug)
            ->filter()
            ->values()
            ->all();

        // Šie pakalpojumi tiek uzskatīti par pilniem komplektiem.
        // Tos nedrīkst kombinēt ne savā starpā, ne ar citiem pakalpojumiem.
        $exclusiveServices = [
            'pilns-detailing-komplekts',
            'vip-programma',
        ];

        // Šiem pakalpojumiem ir vajadzīga papildu informācija par salonu,
        // jo pakalpojuma cenu un darba apjomu ietekmē materiāls un netīrības pakāpe.
        $interiorServices = [
            'salona-dzila-tirisana',
            'pilns-detailing-komplekts',
            'vip-programma',
        ];

        // Sadalām izvēlētos pakalpojumus divās grupās:
        // 1) ekskluzīvie komplekti;
        // 2) standarta pakalpojumi, kurus drīkst kombinēt savā starpā.
        $selectedExclusive = array_values(array_intersect($selectedServiceSlugs, $exclusiveServices));
        $standardSelected = array_values(array_diff($selectedServiceSlugs, $exclusiveServices));

        // Ja lietotājs vienlaikus izvēlējies abus pilnos komplektus,
        // rezervācija netiek pieļauta, jo tie ir savstarpēji izslēdzoši.
        if (count($selectedExclusive) > 1) {
            return back()
                ->withInput()
                ->with('error', 'Pilnais detailing komplekts un VIP programma jārezervē atsevišķi.');
        }

        // Ja izvēlēts viens ekskluzīvais komplekts un paralēli kāds standarta pakalpojums,
        // arī tad rezervācija nav atļauta.
        if (count($selectedExclusive) === 1 && count($standardSelected) > 0) {
            return back()
                ->withInput()
                ->with('error', 'VIP programma un pilnais detailing komplekts nav kombinējami ar citiem pakalpojumiem.');
        }

        // Nosaka, vai konkrētā rezervācija prasa aizpildīt salona laukus.
        // Ja lietotājs izvēlas tikai ārējos pakalpojumus, šie lauki nav obligāti.
        $requiresInteriorDetails = count(array_intersect($selectedServiceSlugs, $interiorServices)) > 0;

        if ($requiresInteriorDetails) {
            // Ja pakalpojums skar salonu, nedrīkst turpināt bez materiāla un stāvokļa.
            if (empty($data['interior_material']) || empty($data['interior_condition'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Lūdzu norādi salona materiālu un stāvokli šim pakalpojumam.');
            }
        } else {
            // Ja salona dati nav vajadzīgi, tos apzināti notīra,
            // lai datubāzē netiktu saglabātas liekas vai novecojušas vērtības.
            $data['interior_material'] = null;
            $data['interior_condition'] = null;
        }

        // Pārveido lietotāja izvēlēto datumu par Carbon objektu,
        // lai varētu veikt ērtas datuma salīdzināšanas operācijas.
        $requestedDate = Carbon::parse($data['date']);

        // Atļautais minimālais rezervācijas datums ir nākamā diena.
        $tomorrow = Carbon::tomorrow();

        // Uzņēmums brīvdienās nestrādā, tāpēc sestdiena un svētdiena tiek noraidītas.
        if ($requestedDate->isWeekend()) {
            return back()
                ->withInput()
                ->with('error', 'Brīvdienās nestrādājam. Lūdzu izvēlies datumu no pirmdienas līdz piektdienai.');
        }

        // Rezervāciju nevar veikt uz šodienu vai pagājušu datumu.
        if ($requestedDate->lessThan($tomorrow)) {
            return back()
                ->withInput()
                ->with('error', 'Rezervācijas iespējamas tikai sākot ar rītdienu.');
        }

        // Izveido oficiāli atļauto laiku sarakstu,
        // pret kuru tiek validēts lietotāja iesniegtais laiks.
        $allowedTimes = $this->generateTimeSlots(120, '09:00', '19:00');

        // Ja laiks nav viens no sistēmā definētajiem slotiem,
        // rezervācija netiek pieņemta.
        if (!in_array($data['time'], $allowedTimes, true)) {
            return back()
                ->withInput()
                ->with('error', 'Laiku var rezervēt no 09:00 līdz 19:00 ar soli 2h.');
        }

        // Saglabā atsevišķi datuma un laika vērtības, lai kods tālāk būtu skaidrāks.
        $date = $data['date'];
        $timeSlot = $data['time'];

        // Pārbauda, vai šim datumam un laikam datubāzē jau neeksistē cita rezervācija.
        $query = Booking::where('date', $date)
            ->where('time_slot', $timeSlot);

        // Ja šajā laikā jau ir cita rezervācija, lietotājs tiek aicināts izvēlēties citu slotu.
        if ($query->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Šis laiks jau ir aizņemts. Lūdzu izvēlies citu laiku.');
        }

        // Rezervācijas izveide un pakalpojumu piesaiste notiek vienā transakcijā.
        // Tas nozīmē: ja kāds no soļiem neizdodas, nekas netiek saglabāts daļēji.
        DB::transaction(function () use ($data, $date, $timeSlot, $selectedServiceIds) {
            // Izveido pašu rezervācijas ierakstu ar klienta, auto un laika informāciju.
            $booking = Booking::create([
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
                'total_price'     => $data['total'],
                'status'          => 'pending',
            ]);

            // Piesaista rezervācijai visus izvēlētos pakalpojumus caur pivot tabulu.
            // Rezultātā viena rezervācija var saturēt vairākus pakalpojumus.
            $booking->services()->sync($selectedServiceIds->all());
        });

        // Pēc veiksmīgas saglabāšanas atgriež lietotāju iepriekšējā lapā
        // un parāda apstiprinājuma paziņojumu.
        return back()->with('success', 'Pieteikums veiksmīgi saglabāts!');
    }

}
