<?php

namespace App\Http\Controllers\API;

use App\Models\BuyCategory;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BuyCategoryController extends Controller
{
    /**
     * Get all buy categories with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 1)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'slug'
                ])
                ->first();

            // Buy Categories - optimized query
            $buyCategories = BuyCategory::query()
                ->select([
                    'id',
                    'language_id',
                    'name',
                    'slug',
                    'image'
                ])
                ->where('status', 'active')
              /*   ->with([
                    'language:id,name'
                ]) */
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Buy categories retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'buy_categories' => $buyCategories,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve buy categories.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
