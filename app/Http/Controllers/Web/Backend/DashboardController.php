<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $total_users = User::count();
        $total_orders = Order::count();
        $total_products = Product::count();
        $total_languages = Language::count();


        /* --- User chart data  start --- */
        $newUsers = User::whereYear('created_at', now()->year)
            ->get();

        // Define all months of the year
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        // Initialize all months with 0
        $userCountsByMonth = array_fill_keys($months, 0);

        // Group the users by the month they were created
        $usersGroupedByMonth = $newUsers->groupBy(function ($user) {
            return $user->created_at->format('F'); // Group by month name
        });

        // Populate the count of users in the correct month
        foreach ($usersGroupedByMonth as $month => $users) {
            $userCountsByMonth[$month] = count($users);
        }

        // Prepare chart data
        $chartData = [
            'labels' => $months,
            'data' => array_values($userCountsByMonth), // 12 values, all integers
        ];
        // dd($chartData);
        /* --- User chart data  end--- */





        /*Total Order chart data start */

        $totalOrders = Order::where('payment_status', 'paid')->whereYear('created_at', now()->year)->get();

        // Initialize all months with 0
        $orderCountsByMonth = array_fill_keys($months, 0);

        // Group the orders by the month they were created
        $ordersGroupedByMonth = $totalOrders->groupBy(function ($order) {
            return $order->created_at->format('F'); // Group by month name
        });

        // Populate the count of orders in the correct month
        foreach ($ordersGroupedByMonth as $month => $orders) {
            $orderCountsByMonth[$month] = count($orders);
        }

        // Prepare chart data
        $orderChartData = [
            'labels' => $months,
            'data' => array_values($orderCountsByMonth), // 12 values, all integers
        ];
        /*Total Order chart data end */


        return view('backend.dashboard', compact('total_users', 'total_orders', 'total_products', 'total_languages', 'chartData', 'orderChartData'));
    }
}
