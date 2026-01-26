<?php

namespace App\Http\Controllers;

use App\Models\WorkItem;

class HomeController extends Controller
{
    /**
     * Parāda sākumlapu ar publiski redzamiem "Mūsu darbi" vienumiem.
     */
    public function index()
    {
        // Ielādē tikai redzamos darbus, sakārtotus pēc pozīcijas.
        return view('home', [
            'workItems' => WorkItem::where('is_visible', true)
                ->orderBy('position')
                ->get(),
        ]);
    }
}
