<?php

namespace App\Http\Controllers;

use App\Models\WorkItem;

class HomeController extends Controller
{
    public function index()
    {
        // Pagaidām vienkārši rādam home.blade.php
        return view('home', [
            'workItems' => WorkItem::where('is_visible', true)
                ->orderBy('position')
                ->get(),
        ]);
    }
}
