<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products with related data.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Product::with([
                'buySubcategory.buyCategory',
                'condition',
                'colors',
                'storages',
            ])->where('status', 'active');

            // Filter by category
            if ($request->has('category_id') && $request->category_id) {
                $query->whereHas('buySubcategory', function ($q) use ($request) {
                    $q->where('buy_category_id', $request->category_id);
                });
            }

            // Filter by subcategory (brand)
            if ($request->has('subcategory_id') && $request->subcategory_id) {
                $query->where('buy_subcategory_id', $request->subcategory_id);
            }

            // Filter by condition
            if ($request->has('condition_id') && $request->condition_id) {
                $query->where('condition_id', $request->condition_id);
            }

            // Filter by color
            if ($request->has('color_id') && $request->color_id) {
                $query->whereHas('colors', function ($q) use ($request) {
                    $q->where('colors.id', $request->color_id);
                });
            }

            // Filter by storage
            if ($request->has('storage_id') && $request->storage_id) {
                $query->whereHas('storages', function ($q) use ($request) {
                    $q->where('storages.id', $request->storage_id);
                });
            }

            // Filter by price range
            if ($request->has('min_price') && $request->min_price) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->has('max_price') && $request->max_price) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filter by product name (partial match)
            if ($request->has('name') && $request->name) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Filter featured products
            if ($request->has('is_featured') && $request->is_featured) {
                $query->where('is_featured', true);
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');

            if (in_array($sortBy, ['price', 'name', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Pagination
            $perPage = $request->get('per_page', 12);
            $products = $query->paginate($perPage);

            return jsonResponse(
                true,
                'Products retrieved successfully.',
                200,
                [
                    'products' => ProductResource::collection($products),
                    'meta' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                    ],
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve products.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Get single product details.
     *
     * @param string $idOrSlug
     * @return JsonResponse
     */
    public function show($idOrSlug): JsonResponse
    {
        try {
            $query = Product::with([
                'buySubcategory.buyCategory',
                'condition',
                'colors',
                'storages',
                'images',
                'protectionServices',
                'accessories',
            ])->where('status', 'active');

            if (ctype_digit((string) $idOrSlug)) {
                $product = (clone $query)->where('id', (int) $idOrSlug)->first();
                if (!$product) {
                    $product = $query->where('slug', $idOrSlug)->first();
                }
            } else {
                $product = $query->where('slug', $idOrSlug)->first();
            }

            if (!$product) {
                return jsonErrorResponse(
                    'Product details not found.',
                    404
                );
            }

            return jsonResponse(
                true,
                'Product Details retrieved successfully.',
                200,
                [
                    'product' => new ProductResource($product),
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve product details.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
