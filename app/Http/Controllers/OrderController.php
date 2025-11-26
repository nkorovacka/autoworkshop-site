<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Validācija
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:50',
            'customer_email'  => 'nullable|email|max:255',
            'quantity'        => 'required|integer|min:1',

            'delivery_method'  => 'required|in:pickup,delivery',
            'delivery_address' => 'nullable|string|max:255',
        ]);

        // Ja piegāde, bet nav adreses
        if ($data['delivery_method'] === 'delivery' && empty($data['delivery_address'])) {
            return back()
                ->withInput()
                ->withErrors(['delivery_address' => 'Lūdzu norādi piegādes adresi vai pakomātu.']);
        }

        // Aprēķina kopējo cenu
        $qty   = $data['quantity'];
        $total = $product->price * $qty;

        // Saglabā pasūtījumu DB
        Order::create([
            'product_id'      => $product->id,
            'customer_name'   => $data['customer_name'],
            'customer_phone'  => $data['customer_phone'],
            'customer_email'  => $data['customer_email'] ?? null,
            'quantity'        => $qty,
            'total_price'     => $total,
            'status'          => 'new',
            'delivery_method' => $data['delivery_method'],
            'delivery_address'=> $data['delivery_address'] ?? null,
        ]);

        return back()->with('success', 'Pasūtījums veiksmīgi noformēts! Mēs ar tevi sazināsimies.');
    }
}
