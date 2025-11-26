<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    // Produktu saraksts (katalogs)
    public function index()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }

    // Viena produkta detalizēta lapa
    public function show(Product $product)
    {
        return view('product-show', compact('product'));
    }
}
