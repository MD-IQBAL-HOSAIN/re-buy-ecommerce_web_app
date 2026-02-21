<?php

namespace App\Http\Controllers\API;

use App\Models\RefurbishedElectronic;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class RefurbishedElectronicController extends Controller
{
    /**
     * Get all refurbished electronics with header
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 3)
                ->select([
                    'id',
                    'language_id',
                    'title',
                    'subtitle',
                    'name as button_text',
                    'slug'
                ])
                ->first();

            // Refurbished Electronics - optimized query
            $refurbishedElectronics = RefurbishedElectronic::query()
                ->select([
                    'id',
                    'language_id',
                    'name',
                    'image',
                    'description',
                    'price'
                ])
                ->with([
                    'language:id,name'
                ])
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Refurbished electronics retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'refurbished_electronics' => $refurbishedElectronics,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve refurbished electronics.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
