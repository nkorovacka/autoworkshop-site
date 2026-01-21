<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    // Produktu saraksts (katalogs)
    public function index()
    {
        $query = Product::query();

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('is_visible', true);
        }

        $products = $query->get();

        return view('products', compact('products'));
    }

    // Viena produkta detalizēta lapa
    public function show(Product $product)
    {
        if ((!auth()->check() || !auth()->user()->isAdmin()) && !$product->is_visible) {
            abort(404);
        }

        return view('product-show', compact('product'));
    }
}
