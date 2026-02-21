<?php

namespace App\Http\Controllers\API;

use App\Models\BuyCategory;
use App\Models\BuySubcategory;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Storage;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class FilterDataController extends Controller
{
    /**
     * Get all filter data (categories, subcategories/brands, colors, conditions, storages)
     * Returns only id and name for each
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Categories (Electronics Categories)
            $categories = BuyCategory::query()
                ->select(['id', 'language_id', 'name'])
                ->where('status', 'active')
                ->orderBy('name')
                ->get();

            // Subcategories / Brands
            $brands = BuySubcategory::query()
                ->select(['id', 'buy_category_id', 'name'])
                ->where('status', 'active')
                ->orderBy('name')
                ->get();

            // Colors
            $colors = Color::query()
                ->select(['id', 'language_id', 'name'])
                ->orderBy('name')
                ->get();

            // Conditions
            $conditions = Condition::query()
                ->select(['id', 'language_id', 'name'])
                ->orderBy('name')
                ->get();

            // Storages
            $storages = Storage::query()
                ->select(['id', 'language_id', 'name'])
                ->orderBy('capacity')
                ->get();

            return jsonResponse(
                true,
                'Filter data retrieved successfully.',
                200,
                [
                    'categories' => $categories,
                    'brands' => $brands,
                    'colors' => $colors,
                    'conditions' => $conditions,
                    'storages' => $storages,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve filter data.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
