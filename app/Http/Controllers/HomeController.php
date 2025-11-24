<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Pagaidām vienkārši rādam home.blade.php
        return view('home');
    }
}
