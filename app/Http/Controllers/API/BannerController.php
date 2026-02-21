<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Retrieve banner data.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $banner = CMS::where('id', 4)
                ->select([
                    'id',
                    'image',
                    'image_two',
                    'image_four',
                    'image_five',
                    'slug'
                ])
                ->first();

            if (!$banner) {
                return jsonErrorResponse(
                    'Banner not found.',
                    404,
                    []
                );
            }

            // Format response with descriptive property names
            $data = [
                'id' => $banner->id,
                'buy_part_banner' => $banner->image,
                'sell_part_banner' => $banner->image_two,
                'video_mobile' => $banner->image_four,
                'video_desktop' => $banner->image_five,
                'slug' => $banner->slug,
            ];

            return jsonResponse(
                true,
                'Banner retrieved successfully.',
                200,
                $data
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve banner.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
