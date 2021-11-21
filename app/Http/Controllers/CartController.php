<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('cart.cart');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cartItems = session()->get('cartItems', []);

        if(isset($cartItems[$id])) {
            $cartItems[$id]['quantity']++;
        } else {
            $cartItems[$id] = [
                "image_path" => $product->image_path,
                "name" => $product->name,
                "brand" => $product->brand,
                "details" => $product->details,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cartItems', $cartItems);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function delete(Request $request)
    {
        if($request->id) {
            $cartItems = session()->get('cartItems');

            if(isset($cartItems[$request->id])) {
                unset($cartItems[$request->id]); 
                session()->put('cartItems', $cartItems);
            }

            return redirect()->back()->with('success', 'Product deleted successfully');
        }
    }
}
