<?php

namespace App\Http\Controllers\API;

use App\Models\CMS;
use App\Models\TrustFeature;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrustFeatureResource;

class TrustFeatureApiController extends Controller
{
    /**
     * Get all Trust Features with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 11)
                ->select([
                    'id',
                    'language_id',
                    'title'
                ])
                ->first();

            // Trust Features - optimized query
            $features = TrustFeature::query()
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'icon'
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Trust features retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'trust_features' => TrustFeatureResource::collection($features),
                ]
            );

        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve trust features.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
