<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Rāda lietotāja grozu un aprēķina starpsummu.
     */
    public function index()
    {
        // Ielādē groza vienumus kopā ar produktiem tikai pašreizējam lietotājam.
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Aprēķina groza starpsummu (vienības cena * daudzums).
        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);

        return view('cart', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Pievieno produktu grozam vai palielina esošo daudzumu.
     */
    public function add(Request $request, Product $product)
    {
        // Validē pieprasīto daudzumu.
        $data = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        // Neļauj pievienot produktu, ja noliktavā nav atlikuma.
        if ($product->stock <= 0) {
            return back()->withErrors(['quantity' => 'Šo produktu pašlaik nevar pievienot (nav noliktavā).']);
        }

        // Atrod esošu groza vienumu vai sagatavo jaunu.
        $cartItem = CartItem::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        // Aprēķina jauno daudzumu (ieskaitot jau esošo).
        $newQuantity = $cartItem->exists ? $cartItem->quantity + $data['quantity'] : $data['quantity'];

        // Pārbauda noliktavas atlikumu.
        if ($newQuantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Pieejams tikai '.$product->stock.' gb noliktavā.']);
        }

        // Saglabā groza vienumu ar aktuālo cenu.
        $cartItem->quantity = $newQuantity;
        $cartItem->unit_price = $product->price;
        $cartItem->save();

        return back()->with('success', $product->name.' pievienots grozam.');
    }

    /**
     * Atjaunina konkrēta groza vienuma daudzumu.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Drošības pārbaude: vienumu var labot tikai tā īpašnieks.
        $this->authorizeCartItem($cartItem);

        // Validē jauno daudzumu.
        $data = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        // Ja produkts vairs neeksistē, groza vienumu dzēš.
        $product = $cartItem->product;
        if (!$product) {
            $cartItem->delete();
            return back()->withErrors(['quantity' => 'Šo produktu vairs nevar pasūtīt.']);
        }

        // Pārbauda, vai noliktavā pietiek atlikuma.
        if ($data['quantity'] > $product->stock) {
            return back()->withErrors(['quantity' => 'Pieejams tikai '.$product->stock.' gb noliktavā.']);
        }

        // Saglabā jauno daudzumu un aktuālo cenu.
        $cartItem->update([
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
        ]);

        return back();
    }

    /**
     * Izņem vienumu no groza.
     */
    public function destroy(CartItem $cartItem)
    {
        // Drošības pārbaude: dzēst var tikai savus vienumus.
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Produkts izņemts no groza.');
    }

    /**
     * Pārbauda, vai groza vienums pieder pašreizējam lietotājam.
     */
    protected function authorizeCartItem(CartItem $cartItem): void
    {
        // Ja lietotājs nav īpašnieks, bloķē piekļuvi.
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
