<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $meta = [
            'areja-mazgasana' => [
                'icon' => '🚿',
                'duration' => '1–1.5 h',
                'features' => [
                    'Divpakāpju mazgāšana ar sniega putām',
                    'Diski, riepas un ieloki ar specializētu ķīmiju',
                    'Hidro‑vaks un ātra spīduma atjaunošana',
                ],
            ],
            'salona-dzila-tirisana' => [
                'icon' => '🪑',
                'duration' => '2–3 h',
                'features' => [
                    'Auduma/ādas ķīmiskā tīrīšana un žāvēšana',
                    'Ozons un antibakteriālā apstrāde pret smakām',
                    'Plastmasu UV aizsardzība un aromāts pēc izvēles',
                ],
            ],
            'virsbuves-pulesana' => [
                'icon' => '💎',
                'duration' => '3–4 h',
                'features' => [
                    'Krāsas biezuma mērījumi un defektu kartēšana',
                    '2–3 pakāpju pulēšana spoguļefektam',
                    'Keramiskā primēšana vai vaks ar UV filtru',
                ],
            ],
            'keramiska-aizsardziba' => [
                'icon' => '🛡️',
                'duration' => '6–8 h',
                'features' => [
                    'Virsmu sagatavošana un pulēšana pirms pārklājuma',
                    'Divu slāņu nano-keramikas sistēma ar garantiju',
                    'Hidrofobija, UV aizsardzība un viegla kopšana',
                ],
            ],
            'pilns-detailing-komplekts' => [
                'icon' => '✨',
                'duration' => '5–6 h',
                'features' => [
                    'Ārējā mazgāšana, clay-bar un pulēšana',
                    'Salona ķīmiskā tīrīšana un ozonēšana',
                    'Motora telpas un disku dziļā kopšana',
                ],
            ],
            'vip-programma' => [
                'icon' => '👑',
                'duration' => '8–10 h',
                'features' => [
                    'Pilns detailing + keramika un lukturu restaurācija',
                    'Ādas atjaunošana, kondicionēšana un aizsardzība',
                    'Personīgs kopšanas komplekts un pēcapkalpošanas konsultācijas',
                ],
            ],
        ];

        $services = Service::orderBy('base_price')->get()->map(function ($service) use ($meta) {
            $slug = $service->slug;
            $service->icon = $meta[$slug]['icon'] ?? '✨';
            $service->duration = $meta[$slug]['duration'] ?? '';
            $service->features = $meta[$slug]['features'] ?? [];
            return $service;
        });

        return view('services', compact('services'));
    }
}
