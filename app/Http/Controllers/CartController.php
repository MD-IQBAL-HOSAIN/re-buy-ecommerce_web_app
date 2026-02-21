<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Recalculate cart pricing.
     */
    private function calculateCartTotals(Cart $cartItem, int $quantity): array
    {
        $product = Product::findOrFail($cartItem->product_id);
        $productPrice = $product->price * $quantity;

        $accessoryPrice = 0;
        if (!empty($cartItem->accessory_id)) {
            $accessory = Accessory::find($cartItem->accessory_id);
            if ($accessory) {
                $accessoryPrice = $accessory->price;
            }
        }

        $protectionServicesPrice = 0;
        if (!empty($cartItem->protection_services)) {
            $serviceIds = is_array($cartItem->protection_services)
                ? $cartItem->protection_services
                : (array) json_decode($cartItem->protection_services, true);
            $serviceIds = array_filter($serviceIds);

            if (!empty($serviceIds)) {
                $productProtection = $product->protectionServices()
                    ->whereIn('protection_services.id', $serviceIds)
                    ->get(['protection_services.id', 'protection_services.price']);

                $protectionServicesPrice = $productProtection->sum('price');
            }
        }

        $totalPrice = $productPrice + $accessoryPrice + $protectionServicesPrice;

        return [
            'product_price' => $productPrice,
            'accessory_price' => $accessoryPrice,
            'protection_services_price' => $protectionServicesPrice,
            'total_price' => $totalPrice,
        ];
    }
    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'color_id' => 'nullable|exists:colors,id',
                'storage_id' => 'nullable|exists:storages,id',
                'accessory_id' => 'nullable|exists:accessories,id',
                'protection_services' => 'nullable|array',
                'quantity' => 'required|integer|min:1',
            ]);

            $userId = Auth::id();

            // Get product
            $product = \App\Models\Product::findOrFail($validated['product_id']);
            $productPrice = $product->price * $validated['quantity'];

            // Check accessory validity (single, not array)
            Log::info('Accessory check: accessory_id = ' . ($validated['accessory_id'] ?? 'null'));
            $accessoryPrice = 0;
            if (!empty($validated['accessory_id'])) {
                $accessory = \App\Models\Accessory::find($validated['accessory_id']);
                $productAccessoryIds = $product->accessories()->pluck('accessories.id')->toArray();
                Log::info('Product accessory ids:', $productAccessoryIds);
                if (!$accessory || !in_array($validated['accessory_id'], $productAccessoryIds)) {
                    Log::warning('Accessory not found or not related to product', ['accessory_id' => $validated['accessory_id'], 'product_id' => $product->id]);
                    return jsonErrorResponse('This accessory is not available for this product.', 400);
                }
                $accessoryPrice = $accessory->price;
            }


            // Check protection services validity and calculate total protection price
            $protectionServicesPrice = 0;
            if (!empty($validated['protection_services'])) {
                $productProtection = $product->protectionServices()->get(['protection_services.id', 'protection_services.price']);
                $productProtectionIds = $productProtection->pluck('id')->toArray();
                foreach ($validated['protection_services'] as $psId) {
                    if (!in_array($psId, $productProtectionIds)) {
                        return jsonErrorResponse('One or more protection services are not available for this product.', 400);
                    }
                    $ps = $productProtection->where('id', $psId)->first();
                    if ($ps) {
                        $protectionServicesPrice += $ps->price;
                    }
                }
            }

            $protectionServicesPrice = $protectionServicesPrice;
            $totalPrice = $productPrice + $accessoryPrice + $protectionServicesPrice;

            Log::info('Cart insert accessory_id: ' . ($validated['accessory_id'] ?? 'null') . ', accessory_price: ' . $accessoryPrice . ', protection_services_price: ' . $protectionServicesPrice);
            $cart = Cart::create([
                'user_id' => $userId,
                'product_id' => $validated['product_id'],
                'color_id' => $validated['color_id'] ?? null,
                'storage_id' => $validated['storage_id'] ?? null,
                'accessory_id' => $validated['accessory_id'] ?? null,
                'protection_services' => $validated['protection_services'] ?? null,
                'quantity' => $validated['quantity'],
                'product_price' => $productPrice,
                'accessory_price' => $accessoryPrice,
                'protection_services_price' => $protectionServicesPrice,
                'total_price' => $totalPrice,
            ]);

            return jsonResponse(
                true,
                'Added to cart successfully.',
                201,
                [
                    'cart' => $cart,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to add to cart.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }


    /**
     * View cart items for the authenticated user.
     */
    public function viewCart()
    {
        try {
            $userId = Auth::id();
            $cartItems = Cart::with('product', 'color', 'storage', 'accessory')
                ->where('user_id', $userId)
                ->where('deleted_at', null)
                ->get();

            return jsonResponse(
                true,
                'Cart items retrieved successfully.',
                200,
                [
                    'cart_items' => $cartItems,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve cart items.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function removeCartItem($id)
    {
        try {
            $userId = Auth::id();
            $cartItem = Cart::where('id', $id)->where('user_id', $userId)->firstOrFail();
            $cartItem->delete();

            return jsonResponse(
                true,
                'Item removed from cart successfully.',
                200
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to remove item from cart.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }


    /**
     * Increment cart item quantity by 1.
     */
    public function incrementCartQuantity(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'nullable|integer|min:1',
            ]);

            $userId = Auth::id();
            $cartItem = Cart::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $delta = $validated['quantity'] ?? 1;
            $newQuantity = $cartItem->quantity + $delta;
            $totals = $this->calculateCartTotals($cartItem, $newQuantity);

            $cartItem->update([
                'quantity' => $newQuantity,
                'product_price' => $totals['product_price'],
                'accessory_price' => $totals['accessory_price'],
                'protection_services_price' => $totals['protection_services_price'],
                'total_price' => $totals['total_price'],
            ]);

            return jsonResponse(
                true,
                'Cart quantity increased successfully.',
                200,
                [
                    'cart' => $cartItem,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to increase cart quantity.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Decrement cart item quantity by 1 (minimum 1).
     */
    public function decrementCartQuantity(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'nullable|integer|min:1',
            ]);

            $userId = Auth::id();
            $cartItem = Cart::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $delta = $validated['quantity'] ?? 1;
            $newQuantity = max(1, $cartItem->quantity - $delta);
            $totals = $this->calculateCartTotals($cartItem, $newQuantity);

            $cartItem->update([
                'quantity' => $newQuantity,
                'product_price' => $totals['product_price'],
                'accessory_price' => $totals['accessory_price'],
                'protection_services_price' => $totals['protection_services_price'],
                'total_price' => $totals['total_price'],
            ]);

            return jsonResponse(
                true,
                'Cart quantity decreased successfully.',
                200,
                [
                    'cart' => $cartItem,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to decrease cart quantity.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
