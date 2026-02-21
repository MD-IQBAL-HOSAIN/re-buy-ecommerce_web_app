<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureDeviceResource;

class FeatureDeviceController extends Controller
{
    /**
     * Get all featured products with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 5)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'slug'
                ])
                ->first();

            // Featured Products - optimized query with eager loading (No N+1)
            $featuredProducts = Product::query()
                ->select([
                    'id',
                    'buy_subcategory_id',
                    'condition_id',
                    'name',
                    'slug',
                    'description',
                    'price',
                    'old_price',
                    'thumbnail',
                    'is_featured'
                ])
                ->where('is_featured', true)
                ->where('status', 'active')
                ->with([
                    'buySubcategory:id,name',
                    'condition:id,name',
                    'colors:id,name',
                    'storages:id,name,capacity',
                    'protectionServices:id,name',
                    'accessories:id,name'
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Featured devices retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'featured_devices' => FeatureDeviceResource::collection($featuredProducts),
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve featured devices.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
