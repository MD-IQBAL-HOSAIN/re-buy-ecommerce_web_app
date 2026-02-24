<?php

namespace App\Http\Controllers\API;

use App\Models\Whatsapp;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class WhatsappApiController extends Controller
{
    /**
     * Get WhatsApp number.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $whatsapp = Whatsapp::query()->select(['id', 'number'])->first();

            return jsonResponse(
                true,
                'WhatsApp number retrieved successfully.',
                200,
                [
                    'Whatsapp' => $whatsapp->number ?? null,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve WhatsApp number.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
