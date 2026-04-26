<?php

namespace Database\Seeders;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Seed default webinar offers.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Offer::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'title' => 'Detailing mācības: profesionālie pamati',
                'type' => 'webinar',
                'format' => 'online',
                'description' => 'Divu stundu tiešraide ar praktiskiem padomiem, kā droši apstrādāt laku un atjaunot virsbūves spīdumu mājas apstākļos.',
                'event_date' => Carbon::create(2026, 6, 12, 19, 0),
                'is_limited' => true,
                'capacity' => 80,
                'registrations_count' => 32,
                'has_timeslots' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Jauno produktu izmēģināšana & Q&A',
                'type' => 'webinar',
                'format' => 'online',
                'description' => 'Ekskluzīvs online pasākums, kur prezentējam jaunāko ķīmiju un instrumentus ar tiešām demonstrācijām.',
                'event_date' => Carbon::create(2026, 7, 3, 18, 30),
                'is_limited' => true,
                'capacity' => 60,
                'registrations_count' => 18,
                'has_timeslots' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Labdarības detailing maratons',
                'type' => 'webinar',
                'format' => 'in_person',
                'description' => 'Tikšanās tiešsaistē, kur dalāmies ar pieredzi un ziedojam līdzekļus bērnu atbalsta fondam, praktiski padomi un viesi.',
                'event_date' => Carbon::create(2026, 9, 10, 20, 0),
                'is_limited' => true,
                'capacity' => 120,
                'registrations_count' => 54,
                'has_timeslots' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Detailing biznesa lekcija meistariem',
                'type' => 'webinar',
                'format' => 'in_person',
                'description' => 'Mentoru vadīta lekcija par pakalpojumu cenu veidošanu, klientu piesaisti un darbnīcas procesiem.',
                'event_date' => Carbon::create(2026, 9, 24, 17, 0),
                'is_limited' => true,
                'capacity' => 50,
                'registrations_count' => 9,
                'has_timeslots' => false,
                'is_active' => true,
            ],
        ];

        foreach ($data as $offer) {
            Offer::create($offer);
        }
    }
}
