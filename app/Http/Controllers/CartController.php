<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;


class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // Get the product from the database
            $product = Product::find($productId);
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'description' => $product->description,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => 'Product added to cart successfully!',
            'cartCount' => count($cart),
        ]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $stripeSession = $request->user()->checkout($lineItems, [
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.show'),
        ]);

        session()->put('invoice_data', $cart);

        return redirect($stripeSession->url);
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Product removed from cart successfully!');
    }

    public function success()
    {
        // Clear the cart data from the session
        session()->forget('cart');

        return view('cart.success');
    }
}
