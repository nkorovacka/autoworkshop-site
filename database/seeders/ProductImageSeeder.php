<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Assign uploaded images to the first products.
     */
    public function run(): void
    {
        $files = [
            'products/pirmaisprodukts.jpg',
            'products/otrsprodukts.jpg',
            'products/tresaisprodukts.jpg',
        ];

        $products = Product::orderBy('id')->get();

        foreach ($products as $index => $product) {
            if (!isset($files[$index])) {
                break;
            }

            $product->image = $files[$index];
            $product->save();
        }
    }
}
