<?php

namespace App\Http\Controllers\API;

use App\Models\ProtectionService;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProtectionServiceController extends Controller
{
    /**
     * Get all protection services with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 2)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'slug'
                ])
                ->first();

            // Protection Services - optimized query with eager loading (No N+1)
            $protectionServices = ProtectionService::query()
                ->select([
                    'id',
                    'language_id',
                    'name',
                    'description',
                    'price'
                ])
                ->with('language:id,name')
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Protection services retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'protection_services' => $protectionServices,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve protection services.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
