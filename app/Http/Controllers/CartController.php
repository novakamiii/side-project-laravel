<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    // Add to cart
    public function addToCart(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($productId);
        $user = Auth::user();

        // Check stock
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        // Check if product already in cart
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($newQuantity > 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Max quantity is 10 per product'
                ], 400);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $validated['quantity']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully'
        ]);
    }

    // Get cart items
    public function getCart()
    {
        $cartItems = Auth::user()->cartItems()
            ->with('product')
            ->get();

        return response()->json([
            'items' => $cartItems,
            'total' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity)
        ]);
    }

    // Remove from cart
    public function removeFromCart($cartItemId)
    {
        $cartItem = Cart::findOrFail($cartItemId);

        // Verify ownership
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from cart'
        ]);
    }

    // Update cart quantity
    public function updateQuantity(Request $request, $cartItemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem = Cart::findOrFail($cartItemId);

        // Verify ownership
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated'
        ]);
    }
}
