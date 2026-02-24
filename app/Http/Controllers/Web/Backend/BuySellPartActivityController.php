<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\BuySellPartActivity;
use Yajra\DataTables\Facades\DataTables;

class BuySellPartActivityController extends Controller
{
    /**
     * Display a listing of buy/sell activity status.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $activity = BuySellPartActivity::query()->first();

            if (!$activity) {
                $activity = BuySellPartActivity::create([
                    'buy_status' => 'active',
                    'sell_status' => 'active',
                ]);
            }

            return DataTables::of([$activity])
                ->addIndexColumn()
                ->addColumn('buy_status', function ($data) {
                    $backgroundColor  = $data->buy_status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->buy_status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showBuyStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="buySwitch' . $data->id . '" getAreaid="' . $data->id . '" name="buy_status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="buySwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('sell_status', function ($data) {
                    $backgroundColor  = $data->sell_status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->sell_status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showSellStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="sellSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="sell_status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="sellSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->rawColumns(['buy_status', 'sell_status'])
                ->make();
        }

        return view('backend.layout.buy-sell-part-activity.index');
    }

    /**
     * Toggle buy status.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function buyStatus(int $id): JsonResponse
    {
        $data = BuySellPartActivity::query()->findOrFail($id);

        if ($data->buy_status == 'active') {
            $data->buy_status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Buy status unpublished successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->buy_status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Buy status published successfully.',
                'data'    => $data,
            ]);
        }
    }

    /**
     * Toggle sell status.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function sellStatus(int $id): JsonResponse
    {
        $data = BuySellPartActivity::query()->findOrFail($id);

        if ($data->sell_status == 'active') {
            $data->sell_status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Sell status unpublished successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->sell_status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Sell status published successfully.',
                'data'    => $data,
            ]);
        }
    }
}
