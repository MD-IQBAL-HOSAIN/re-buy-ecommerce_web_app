<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Models\CMS;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Get all reviews
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Header CMS data - optimized with specific columns only
            $header = CMS::where('id', 6)
                ->select([
                    'title',
                    'subtitle',
                    'slug'
                ])
                ->first();

            // Reviews with eager loading - optimized query
            $reviews = Review::query()
                ->select([
                    'id',
                    'language_id',
                    'product_id',
                    'user_id',
                    'rating',
                    'review_text',
                    'status'
                ])
                ->where('status', 'active')
                ->with([
                    'language:id,name',
                    'product:id,name',
                    'user:id,name'
                ])
                ->latest()
                ->get();

            //ReviewResource for formatting response data
            return jsonResponse(
                true,
                'Reviews retrieved successfully.',
                200,
                [
                    'header' => $header,
                    'reviews' => ReviewResource::collection($reviews),
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve reviews.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Store a new review
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'language_id' => 'nullable|exists:languages,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return validationError($validator->errors());
        }

        try {
            // Check if user already reviewed this product
            $existingReview = Review::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingReview) {
                return jsonErrorResponse(
                    'You have already reviewed this product.',
                    422,
                    []
                );
            }

            // Create review using validated data
            $review = Review::create([
                'language_id' => $request->language_id,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'review_text' => $request->review_text,
            ]);

            return jsonResponse(
                true,
                'Review created successfully.',
                201,
                $review
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to create review.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
