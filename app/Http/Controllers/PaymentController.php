<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payWithStripe(Request $request)
    {
        $userId = Auth::id();
        $cart   = Cart::where('user_id', $userId)
            ->where('deleted_at', null)
            ->get();

        if ($cart->isEmpty()) {
            return jsonErrorResponse('Cart is empty', 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        // Line items for Stripe checkout
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'gbp',
                    'product_data' => [
                        'name' => 'Product #' . $item->product_id,
                    ],
                    'unit_amount'  => $item->total_price * 100, // Stripe uses cents
                ],
                'quantity'   => 1,
            ];
        }

        // Create Stripe session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}', // Success URL
            'cancel_url'           => route('payment.cancel'),                                        // Cancel URL
            'metadata'             => [
                'user_id' => $userId,
            ],
        ]);

        // Send the checkout URL to frontend
        return jsonResponse(true, 'Stripe session created', 200, [
            'checkout_url' => $session->url, // Frontend will use this URL to redirect
        ]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the session_id from the request
        $sessionId = $request->query('session_id');
        if (! $sessionId) {
            return jsonErrorResponse('Session missing', 400);
        }

        // Retrieve the session details from Stripe
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Check if the payment status is 'paid'
        if ($session->payment_status !== 'paid') {
            return jsonErrorResponse('Payment not completed', 400);
        }

        $userId = $session->metadata->user_id;

        // Retrieve the cart items for the authenticated user
        $cart = Cart::where('user_id', $userId)->where('deleted_at', null)->get();

        // If cart is empty, abort
        if ($cart->isEmpty()) {
            return jsonErrorResponse('Cart is empty', 400);
        }

        DB::beginTransaction(); // Start the database transaction

        try {
            // Create the order
            $order = Order::create([
                'user_id'        => $userId,
                'payment_id'     => $session->payment_intent,
                'order_number'   => uniqid('ORD-'),
                'total_amount'   => $cart->sum('total_price'),
                'payment_status' => 'paid',
                'status'         => 'pending',
            ]);

            // Create the order details for each cart item
            foreach ($cart as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                if (! $product) {
                    throw new \Exception('Product not found for cart item.');
                }
                // Check if the product has enough stock
                if ($product->stock < $item->quantity) {
                    throw new \Exception('Insufficient stock for product #' . $item->product_id);
                }
                // Decrement the product stock
                $product->decrement('stock', $item->quantity);

                OrderDetail::create([
                    'order_id'                  => $order->id,
                    'product_id'                => $item->product_id,
                    'color_id'                  => $item->color_id,
                    'storage_id'                => $item->storage_id,
                    'accessory_id'              => $item->accessory_id,
                    'protection_services'       => $item->protection_services,
                    'quantity'                  => $item->quantity,
                    'unit_price'                => $item->product_price / $item->quantity, // unit price
                    'accessory_price'           => $item->accessory_price,
                    'protection_services_price' => $item->protection_services_price,
                    'total_price'               => $item->total_price,
                ]);
            }

            // Delete cart items for the authenticated user after order creation
            Cart::where('user_id', $userId)->delete();

            DB::commit(); // Commit the transaction

            // Redirect to the success URL after creating the order
            return redirect(env('PAYMENT_SUCCESS_URL'))->with('order_number', $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack(); // If an error occurs, rollback the transaction
            return jsonErrorResponse('Order creation failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function cancel()
    {
        // Redirect to cancel URL
        return redirect(env('PAYMENT_CANCEL_URL'))->with('t-error', 'Payment Failed.');
    }
}
