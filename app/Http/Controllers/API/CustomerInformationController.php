<?php

namespace App\Http\Controllers\API;

use App\Models\CustomerInformation;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CustomerInformationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:50',
                'address' => 'required|string|max:255',
                'country' => 'required|string|max:200',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:50',
            ]);

            // Get authenticated user ID
            $UserId = Auth::id();

            // Create CustomerInformation one by one (single insert)
            $customerInfo = new CustomerInformation();
            $customerInfo->user_id = $UserId;
            $customerInfo->name = $validated['name'];
            $customerInfo->email = $validated['email'];
            $customerInfo->phone = $validated['phone'];
            $customerInfo->address = $validated['address'];
            $customerInfo->country = $validated['country'];
            $customerInfo->city = $validated['city'] ?? null;
            $customerInfo->state = $validated['state'] ?? null;
            $customerInfo->postal_code = $validated['postal_code'] ?? null;
            $customerInfo->save();

            // Get latest cart for auth user
            $user = Auth::user();
            if ($user) {
                $latestCart = Cart::where('user_id', $user->id)->latest()->first();
                if ($latestCart) {
                    $latestCart->customer_information_id = $customerInfo->id;
                    $latestCart->save();
                }
            }

            return jsonResponse(
                true,
                'Customer information created successfully.',
                201,
                $customerInfo
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return jsonErrorResponse(
                'Validation failed.',
                422,
                $e->errors()
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to create customer information.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
