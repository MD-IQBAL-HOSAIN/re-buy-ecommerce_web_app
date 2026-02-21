<?php

namespace App\Http\Controllers\API;

use App\Models\CMS;
use App\Models\SellElectronics;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellElectronicsResource;

class SellElectronicsApiController extends Controller
{
    /**
     * Get all Sell Electronics with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data (ID 8 from HeaderController)
            $header = CMS::where('id', 8)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'name as button_text', // Button text
                ])
                ->first();

            // Sell Electronics List
            $items = SellElectronics::query()
                ->select([
                    'id',
                    'language_id',
                    'name',
                    'description',
                    'image',
                    'price'
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Sell electronics retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'sell_electronics' => SellElectronicsResource::collection($items),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve sell electronics.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
