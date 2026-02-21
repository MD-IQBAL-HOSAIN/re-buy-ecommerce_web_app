<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\Order;
use App\Models\Cart;
use App\Models\CustomerInformation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::with('user')->where('payment_status', 'paid')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('order_number', function ($data) {
                    return $data->order_number ?? 'N/A';
                })
                ->addColumn('user', function ($data) {
                    return $data->user->name ?? 'N/A';
                })
                ->addColumn('total_amount', function ($data) {
                    return '€ ' . number_format($data->total_amount, 2);
                })
                ->addColumn('payment_status', function ($data) {
                    switch ($data->payment_status) {
                        case 'paid':
                            $payment_status = '<span class="badge bg-primary">Paid</span>';
                            break;
                        case 'pending':
                            $payment_status = '<span class="badge bg-warning">Pending</span>';
                            break;
                        case 'failed':
                            $payment_status = '<span class="badge bg-danger">Failed</span>';
                            break;
                        case 'refunded':
                            $payment_status = '<span class="badge bg-info">Refunded</span>';
                            break;
                        default:
                            $payment_status = 'N/A';
                            break;
                    }
                    return $payment_status;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 'pending':
                            $payment_status = '<span class="badge bg-warning">Pending</span>';
                            break;
                        case 'failed':
                            $payment_status = '<span class="badge bg-danger">Failed</span>';
                            break;
                        case 'refunded':
                            $payment_status = '<span class="badge bg-info">Refunded</span>';
                            break;
                        default:
                            $payment_status = 'N/A';
                            break;
                    }
                    return $payment_status;
                })
                ->addColumn('status', function ($data) {
                    $statuses = [
                        'pending' => '<span class="badge bg-warning">Pending</span>',
                        'processing' => '<span class="badge bg-info">Processing</span>',
                        'shipped' => '<span class="badge bg-success">Shipped</span>',
                        'delivered' => '<span class="badge bg-primary">Delivered</span>',
                        'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                    ];

                    $status_html = '<select class="form-select" aria-label="Default select example" onchange="changeStatus(this, ' . $data->id . ')">';
                    $status_html .= '<option value="">Select Status</option>';
                    foreach ($statuses as $key => $value) {
                        $selected = $data->status === $key ? 'selected' : '';
                        $status_html .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                    }
                    $status_html .= '</select>';

                    return $status_html;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('order.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['order_number', 'user', 'total_amount', 'payment_status', 'status', 'action'])
                ->make();
        }
        return view("backend.layout.orders.index");
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $data = Order::with([
            'user',
            'orderDetails.product',
            'orderDetails.color',
            'orderDetails.storage',
            'orderDetails.accessory'
        ])->findOrFail($id);

        $customerInfo = null;

        foreach ($data->orderDetails as $detail) {
            // withTrashed() retrieves soft deleted data.
            $cart = Cart::withTrashed()
                ->where('user_id', $data->user_id)
                ->where('product_id', $detail->product_id)
                ->whereNotNull('customer_information_id')
                ->latest()
                ->first();

            if ($cart && $cart->customer_information_id) {
                $customerInfo = CustomerInformation::find($cart->customer_information_id);
                break;
            }
        }

        return view('backend.layout.orders.show', compact('data', 'customerInfo'));
    }

    /**
     * Remove the specified order from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = Order::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the order.',
            ]);
        }
    }

    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, int $id): JsonResponse
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Get the new status from the request
        $newStatus = $request->input('status');

        // Validate the status
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled']; // Add all valid statuses
        if (!in_array($newStatus, $validStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status provided.',
            ]);
        }

        // Update the order status
        $order->status = $newStatus;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'data'    => $order,
        ]);
    }
}
