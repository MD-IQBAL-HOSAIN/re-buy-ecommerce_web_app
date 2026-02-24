<?php

namespace App\Http\Controllers\API;

use App\Models\SellProduct;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellProductResource;

class SellProductApiController extends Controller
{
    /**
     * Get all Sell Products
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $items = SellProduct::query()
                ->select([
                    'id',
                    'language_id',
                    'buy_subcategory_id',
                    'name',
                    'short_name',
                    'slug',
                    'image',
                    'storage',
                    'color',
                    'model',
                    'ean',
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Sell products retrieved successfully.',
                200,
                [
                    'sell_products' => SellProductResource::collection($items),
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve sell products.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
