<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Parāda produktu katalogu, filtrējot neredzamos produktus parastiem lietotājiem.
     */
    public function index()
    {
        // Izveido pamatvaicājumu, ko var pielāgot pēc lietotāja lomas.
        $query = Product::query();

        // Tikai admins drīkst redzēt neredzamos produktus.
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('is_visible', true);
        }

        // Ielādē produktus pēc izvēlētā filtra.
        $products = $query->get();

        return view('products', compact('products'));
    }

    /**
     * Parāda viena produkta detalizēto lapu ar piekļuves kontroli.
     */
    public function show(Product $product)
    {
        // Ja produkts nav redzams un lietotājs nav admins, atgriež 404.
        if ((!auth()->check() || !auth()->user()->isAdmin()) && !$product->is_visible) {
            abort(404);
        }

        return view('product-show', compact('product'));
    }
}
