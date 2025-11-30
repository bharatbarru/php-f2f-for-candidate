<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request)
{
    $user = auth()->user();

    \Log::info('Add to cart called');
    \Log::info($request->all());

    $request->validate([
        'product_id' => 'required',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::find($request->product_id);
    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    if ($product->stock < $request->quantity) {
        return response()->json([
            'message' => "Only {$product->stock} units left"
        ], 400);
    }

    $cart = Cart::firstOrCreate(
        ['user_id' => $user->id, 'status' => 'open'],
        ['total_amount' => 0]
    );

    $unit_price = $product->price;
    $line_total = $unit_price * $request->quantity;

    $cartItem = CartItem::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'cart_id' => $cart->id,
        'quantity' => $request->quantity,
        'unit_price' => $unit_price,
        'line_total' => $line_total
    ]);

    // Update cart total
    $cart->total_amount += $line_total;
    $cart->save();

    $product->stock -= $request->quantity;
    $product->save();

    return response()->json([
        'message' => 'Product added to cart',
        'cart' => $cart,
        'cart_item' => $cartItem
    ]);
}
}
