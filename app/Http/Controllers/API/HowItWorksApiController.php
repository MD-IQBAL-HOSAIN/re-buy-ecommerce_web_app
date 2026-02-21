<?php

namespace App\Http\Controllers\API;

use App\Models\CMS;
use App\Models\HowItWork;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\HowItWorksResource;

class HowItWorksApiController extends Controller
{
    /**
     * Get How It Works items with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data (ID 10 from HowItWorksHeaderController)
            $header = CMS::where('id', 10)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'name as button_text',
                ])
                ->first();

            // How It Works Steps
            $items = HowItWork::query()
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'image',
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'How it works retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'how_it_works' => HowItWorksResource::collection($items),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve how it works.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
