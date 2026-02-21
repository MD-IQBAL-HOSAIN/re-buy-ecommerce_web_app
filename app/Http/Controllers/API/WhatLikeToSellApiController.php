<?php

namespace App\Http\Controllers\API;

use App\Models\CMS;
use App\Models\BuyCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class WhatLikeToSellApiController extends Controller
{
    /**
     * Get What Like To Sell Categories with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data (ID 9 from WhatLikeToSellController)
            $header = CMS::where('id', 9)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                ])
                ->first();

            $categories = BuyCategory::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                    'image',
                ])
                ->where('status', 'active')
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Sell categories retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'categories' => CategoryResource::collection($categories),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve sell categories.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }


    /**
     * Get Subcategories by Category ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getSubCategories($id): JsonResponse
    {
        try {
            $subCategories = \App\Models\BuySubcategory::query()
                ->select([
                    'id',
                    'buy_category_id',
                    'name',
                    'slug',
                    'image',
                ])
                ->where('buy_category_id', $id)
                ->where('status', 'active')
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Subcategories retrieved successfully.',
                200,
                [
                    'subcategories' => \App\Http\Resources\SubcategoryResource::collection($subCategories),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve subcategories.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Get Products (Name & Thumbnail) by Subcategory ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getProductsBySubCategory($id): JsonResponse
    {
        try {
            $products = \App\Models\Product::query()
                ->with(['storages','colors']) // Eager load storages and colors for the product
                ->select([
                    'id',
                    'buy_subcategory_id',
                    'name',
                    'slug',
                    'thumbnail',
                ])
                ->where('buy_subcategory_id', $id)
                ->where('status', 'active')
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Products retrieved successfully.',
                200,
                [
                    'products' => \App\Http\Resources\ProductNameResource::collection($products),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve products.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
