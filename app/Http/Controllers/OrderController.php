<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Izveido jaunu pasūtījumu konkrētam produktam.
     */
    public function store(Request $request, Product $product)
    {
        // Validē klienta un piegādes datus, kā arī pasūtīto daudzumu.
        $data = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => [
                'required',
                'regex:/^\+?\d+$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D/', '', (string) $value);
                    if (strlen($digits) > 13) {
                        $fail('Telefona numurs ir par garu (maks. 13 cipari).');
                    }
                },
            ],
            'customer_email'  => 'nullable|email|max:255',
            'quantity'        => 'required|integer|min:1',

            'delivery_method'  => 'required|in:pickup,delivery',
            'delivery_address' => 'nullable|string|max:255',
        ], [
            'customer_phone.regex' => 'Telefona numurs ir par garu vai neatbilstošā formātā (maks. 13 cipari un izvēles +).',
        ]);

        // Ja izvēlēta piegāde, adrese ir obligāta.
        if ($data['delivery_method'] === 'delivery' && empty($data['delivery_address'])) {
            return back()
                ->withInput()
                ->withErrors(['delivery_address' => 'Lūdzu norādi piegādes adresi vai pakomātu.']);
        }

        // Aprēķina kopējo cenu, ņemot vērā produkta cenu un daudzumu.
        $qty   = $data['quantity'];
        $total = $product->price * $qty;

        // Saglabā pasūtījumu datubāzē ar statusu "new".
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
