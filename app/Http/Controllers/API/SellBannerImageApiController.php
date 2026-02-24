<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SellBannerImage;
use Illuminate\Http\JsonResponse;

class SellBannerImageApiController extends Controller
{
    /**
     * Retrieve sell banner images.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $images = SellBannerImage::query()
                ->select(['id', 'image'])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Sell banner images retrieved successfully.',
                200,
                [
                    'Sell-Category-images' => $images,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve sell banner images.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
