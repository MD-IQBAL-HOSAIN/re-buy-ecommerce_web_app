<?php

namespace App\Http\Controllers\API;

use App\Models\Seo;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class SeoApiController extends Controller
{
    /**
     * Get active SEO scripts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $scripts = Seo::query()
                ->where('status', 'active')
                ->select(['id', 'script'])
                ->latest()
                ->get();

            $scripts = $scripts->map(function ($item) {
                $script = $item->script ?? '';
                $script = str_replace(["\r\n", "\r", "\n"], '', $script);
                return [
                    'id' => $item->id,
                    'script' => $script,
                ];
            });

            return jsonResponse(
                true,
                'SEO scripts retrieved successfully.',
                200,
                [
                    'seo' => $scripts,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve SEO scripts.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
