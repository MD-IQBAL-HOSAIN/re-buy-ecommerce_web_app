<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    /**
     * Get authenticated user's order history.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $userId = Auth::id();

            $query = Order::with([
                'orderDetails.product',
                'orderDetails.color',
                'orderDetails.storage',
                'orderDetails.accessory',
            ])->where('user_id', $userId)
                ->orderBy('created_at', 'desc');

            $perPage = $request->get('per_page', 10);
            $orders = $query->paginate($perPage);

            return jsonResponse(
                true,
                'Order history retrieved successfully.',
                200,
                [
                    'orders' => $orders->items(),
                    'meta' => [
                        'current_page' => $orders->currentPage(),
                        'last_page' => $orders->lastPage(),
                        'per_page' => $orders->perPage(),
                        'total' => $orders->total(),
                    ],
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve order history.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Get a specific order details for authenticated user.
     */
    public function show($id): JsonResponse
    {
        try {
            $userId = Auth::id();

            $order = Order::with([
                'orderDetails.product',
                'orderDetails.color',
                'orderDetails.storage',
                'orderDetails.accessory',
            ])->where('user_id', $userId)
                ->where('id', $id)
                ->first();

            if (!$order) {
                return jsonErrorResponse('Order not found.', 404);
            }

            return jsonResponse(
                true,
                'Order details retrieved successfully.',
                200,
                [
                    'order' => $order,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve order details.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
