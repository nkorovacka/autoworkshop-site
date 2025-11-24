<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Paņem visus produktus no DB
        $products = Product::all();

        // Rāda resources/views/products.blade.php
        return view('products', compact('products'));
    }
}
