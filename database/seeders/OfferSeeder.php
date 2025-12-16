<?php

namespace Database\Seeders;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Seed default webinar offers.
     */
    public function run(): void
    {
        Offer::truncate();

        $data = [
            [
                'title' => 'Masterclass: Keramiskā pārklājuma mīti',
                'type' => 'webinar',
                'description' => '90 min. lekcija ar demonstrācijām par keramisko pārklājumu uzklāšanu un kopšanu.',
                'event_date' => Carbon::now()->addDays(10)->setTime(19, 0),
                'is_limited' => true,
                'capacity' => 60,
                'registrations_count' => 24,
                'has_timeslots' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Tiešsaistes mācības: Salona dziļā tīrīšana',
                'type' => 'webinar',
                'description' => 'Praktiskas video nodarbības par auduma un ādas kopšanas metodēm mājas apstākļos.',
                'event_date' => Carbon::now()->addDays(18)->setTime(18, 30),
                'is_limited' => true,
                'capacity' => 40,
                'registrations_count' => 12,
                'has_timeslots' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Jauno produktu prezentācija & Q&A',
                'type' => 'webinar',
                'description' => 'Ekskluzīvs pasākums, kurā prezentējam jaunākos detailing produktus, bonusi dalībniekiem.',
                'event_date' => Carbon::now()->addDays(25)->setTime(20, 0),
                'is_limited' => true,
                'capacity' => 80,
                'registrations_count' => 35,
                'has_timeslots' => false,
                'is_active' => true,
            ],
        ];

        foreach ($data as $offer) {
            Offer::create($offer);
        }
    }
}
