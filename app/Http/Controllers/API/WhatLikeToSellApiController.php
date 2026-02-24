<?php

namespace App\Http\Controllers\API;

use App\Models\CMS;
use App\Models\BuyCategory;
use App\Models\SellProduct;
use App\Models\BuySubcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SellProductNameResource;
use App\Http\Resources\SubcategoryResource;

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
                    'subcategories' => SubcategoryResource::collection($subCategories),
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
     * Get Featured Subcategories by Category ID or Slug
     *
     * @param int|string $idOrSlug
     * @return JsonResponse
     */
    public function getFeaturedSubCategories(Request $request, $idOrSlug): JsonResponse
    {
        try {
            $categoryId = null;

            if (is_numeric($idOrSlug)) {
                $categoryId = (int) $idOrSlug;
            } else {
                $categoryId = BuyCategory::where('slug', $idOrSlug)->value('id');
            }

            if (! $categoryId) {
                return jsonErrorResponse(
                    'Category not found.',
                    404
                );
            }

            $query = BuySubcategory::query()
                ->select([
                    'id',
                    'buy_category_id',
                    'name',
                    'slug',
                    'image',
                ])
                ->where('buy_category_id', $categoryId)
                ->where('status', 'active');

            if ($request->filled('featured')) {
                $query->where('is_featured', (int) $request->featured);
            }

            $subCategories = $query->latest()->get();

            return jsonResponse(
                true,
                'Featured subcategories retrieved successfully.',
                200,
                [
                    'subcategories' => SubcategoryResource::collection($subCategories),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve featured subcategories.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Get Products (Name & Thumbnail) by Subcategory ID
     *
     * @param int|string $idOrSlug
     * @return JsonResponse
     */
    public function getProductsBySubCategory($idOrSlug): JsonResponse
    {
        try {
            $subcategoryId = null;

            if (is_numeric($idOrSlug)) {
                $subcategoryId = (int) $idOrSlug;
            } else {
                $subcategoryId = BuySubcategory::where('slug', $idOrSlug)->value('id');
            }

            if (! $subcategoryId) {
                return jsonErrorResponse(
                    'Subcategory not found.',
                    404
                );
            }

            $products = SellProduct::query()
                ->select([
                    'id',
                    'buy_subcategory_id',
                    'name',
                    'slug',
                    'image',
                ])
                ->where('buy_subcategory_id', $subcategoryId)
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Sell products retrieved successfully.',
                200,
                [
                    'products' => SellProductNameResource::collection($products),
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
