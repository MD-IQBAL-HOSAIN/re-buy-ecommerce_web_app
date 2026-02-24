<?php

namespace App\Http\Controllers\API;

use App\Models\BuySellPartActivity;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BuySellPartActivityApiController extends Controller
{
    /**
     * Get buy/sell activity status.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $activity = BuySellPartActivity::query()->first();

            if (!$activity) {
                $activity = BuySellPartActivity::create([
                    'buy_status' => 'active',
                    'sell_status' => 'active',
                ]);
            }

            return jsonResponse(
                true,
                'Buy/sell activity status retrieved successfully.',
                200,
                [
                    'buy_status' => $activity->buy_status,
                    'sell_status' => $activity->sell_status,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve buy/sell activity status.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
