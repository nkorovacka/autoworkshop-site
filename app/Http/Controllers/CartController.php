<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $items->sum(fn ($item) => (float) $item->unit_price * $item->quantity);

        return view('cart', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($product->stock <= 0) {
            return back()->withErrors(['quantity' => 'Šo produktu pašlaik nevar pievienot (nav noliktavā).']);
        }

        $cartItem = CartItem::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $newQuantity = $cartItem->exists ? $cartItem->quantity + $data['quantity'] : $data['quantity'];

        if ($newQuantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Pieejams tikai '.$product->stock.' gb noliktavā.']);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->unit_price = $product->price;
        $cartItem->save();

        return back()->with('success', $product->name.' pievienots grozam.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);

        $data = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = $cartItem->product;
        if (!$product) {
            $cartItem->delete();
            return back()->withErrors(['quantity' => 'Šo produktu vairs nevar pasūtīt.']);
        }

        if ($data['quantity'] > $product->stock) {
            return back()->withErrors(['quantity' => 'Pieejams tikai '.$product->stock.' gb noliktavā.']);
        }

        $cartItem->update([
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
        ]);

        return back();
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Produkts izņemts no groza.');
    }

    protected function authorizeCartItem(CartItem $cartItem): void
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
