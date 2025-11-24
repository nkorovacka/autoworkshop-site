<?php

namespace App\Http\Controllers;

class ServiceController extends Controller
{
    public function index()
    {
        // Pagaidām iedosim statiskus pakalpojumus (vēlāk nomainīsim uz DB)
        $services = [
            ['name' => 'Ārējā mazgāšana', 'price' => 25, 'description' => 'Rūpīga virsbūves mazgāšana.'],
            ['name' => 'Salona tīrīšana', 'price' => 45, 'description' => 'Salona ķīmiskā tīrīšana.'],
            ['name' => 'Pilns detailing', 'price' => 120, 'description' => 'Gan salons, gan virsbūve, pulēšana un aizsardzība.'],
        ];

        return view('services', compact('services'));
    }
}
