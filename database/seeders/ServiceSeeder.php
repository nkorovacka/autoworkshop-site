<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed the application's service catalogue.
     */
    public function run(): void
    {
        Service::query()->delete();

        $services = [
            [
                'name' => 'Ārējā mazgāšana',
                'base_price' => 30,
                'description' => 'Divpakāpju mazgāšana ar sniega putām, disku un riepu ķīmiju, kā arī hidro‑vaksu ātrai spīduma atjaunošanai.',
            ],
            [
                'name' => 'Salona dziļā tīrīšana',
                'base_price' => 45,
                'description' => 'Pilna auduma un ādas ķīmiskā tīrīšana, ozonēšana un aromatizēšana, kas izņem netīrumus un smakas.',
            ],
            [
                'name' => 'Virsbūves pulēšana',
                'base_price' => 80,
                'description' => 'Divu vai trīs posmu pulēšana ar spoguļefektu, skrāpējumu samazināšanu un sagatavošanu aizsargpārklājumam.',
            ],
            [
                'name' => 'Keramiskā aizsardzība',
                'base_price' => 150,
                'description' => 'Profesionala nano-keramikas uzklāšana ar garantētu hidrofobiju un UV aizsardzību līdz 24 mēnešiem.',
            ],
            [
                'name' => 'Pilns detailing komplekts',
                'base_price' => 120,
                'description' => 'Salona un ārējā kopšana vienā vizītē: mazgāšana, pulēšana, salona ķīmija un motora telpa.',
            ],
            [
                'name' => 'VIP programma',
                'base_price' => 250,
                'description' => 'Premium komplekts ar keramiku, lukturu pulēšanu, salona ādas atjaunošanu un personalizētu kopšanas komplektu.',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
