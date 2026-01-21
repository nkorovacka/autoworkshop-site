<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed three detailing product entries.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Crystal Shield Pro keramika',
                'description' => 'Divkomponentu nano-keramikas aizsargs virsbūves spīdumam un UV aizsardzībai.',
                'price' => 89.00,
                'stock' => 8,
                'supplier' => 'CeramicLab Baltic',
                'origin_country' => 'Vācija',
                'usage_instructions' => 'Uzklāj uz attaukotas virsmas, pulē ar mikrošķiedru drānu, ļauj nožūt 12h.',
                'long_description' => 'Premium līmeņa keramiskā aizsardzība, kas nodrošina hidrofobisku efektu un aizsargkārtu līdz 18 mēnešiem. Komplektā aplikatora sūklis un divi mikrošķiedras audumi.',
            ],
            [
                'name' => 'Interior Detox komplekts',
                'description' => 'Salona ķīmijas trio audumam, ādai un plastmasai ar antibakteriālu efektu.',
                'price' => 54.50,
                'stock' => 15,
                'supplier' => 'Detailing Supply LV',
                'origin_country' => 'Itālija',
                'usage_instructions' => 'Izsmidzini, iemasē ar birsti, noslauki ar sausas mikrošķiedras drānu.',
                'long_description' => 'Pilnvērtīgs salona kopšanas komplekts ar dziļi tīrošu audumu līdzekli, ādas kondicionieri un antistatisku plastmasas kopšanas aerosolu. Drošs arī bērnu sēdeklīšiem.',
            ],
            [
                'name' => 'Hydro Foam Wash koncentrāts',
                'description' => 'pH-neitrālas aktīvās putas ātrai ārējai mazgāšanai ar vasku.',
                'price' => 32.90,
                'stock' => 20,
                'supplier' => 'Nordic Auto Care',
                'origin_country' => 'Somija',
                'usage_instructions' => 'Atšķaidi 1:10 putu pistolē, uzklāj un noskalo pēc 3 minūtēm.',
                'long_description' => 'Koncentrēts mazgāšanas līdzeklis ar vasku, kas neizēd keramiku un sniedz tūlītēju spīdumu. Samazina ūdens nosēdumus un atstāj hidrofobisku plēvīti.',
            ],
        ];

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['name' => $productData['name']],
                array_merge($productData, ['is_visible' => true])
            );
        }
    }
}
