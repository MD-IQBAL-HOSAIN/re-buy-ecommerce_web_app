<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get first storage and color for display
        $firstStorage = $this->storages->first();
        $firstColor = $this->colors->first();

        // Build storage display (e.g., "256GB")
        $storageDisplay = null;
        if ($firstStorage) {
            $storageDisplay = (int) $firstStorage->capacity . ' ' . $firstStorage->name;
        }

        // Build color display (e.g., "Deep Purple")
        $colorDisplay = $firstColor ? $firstColor->name : null;

        // Build subtitle (e.g., "256GB • Deep Purple")
        $subtitleParts = array_filter([$storageDisplay, $colorDisplay]);
        $subtitle = !empty($subtitleParts) ? implode(' • ', $subtitleParts) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'subtitle' => $subtitle,
            'thumbnail' => $this->thumbnail,
            'price' => (float) $this->price,
            'old_price' => $this->old_price ? (float) $this->old_price : null,
            'discount_price' => $this->discount_price ? (float) $this->discount_price : null,
            'stock' => $this->stock,
            'is_featured' => $this->is_featured,
            'sku' => $this->sku,

            // Category info
            'category' => $this->whenLoaded('buySubcategory', function () {
                return [
                    'id' => $this->buySubcategory->buyCategory->id ?? null,
                    'name' => $this->buySubcategory->buyCategory->name ?? null,
                ];
            }),

            // Brand (Subcategory) info
            'brand' => $this->whenLoaded('buySubcategory', function () {
                return [
                    'id' => $this->buySubcategory->id,
                    'name' => $this->buySubcategory->name,
                ];
            }),

            // Condition info
            'condition' => $this->whenLoaded('condition', function () {
                return [
                    'id' => $this->condition->id,
                    'name' => $this->condition->name,
                ];
            }),

            // Storage options (first for display, all for details)
            'storage' => $storageDisplay,
            'storages' => $this->whenLoaded('storages', function () {
                return $this->storages->map(function ($storage) {
                    return [
                        'id' => $storage->id,
                        'name' => $storage->name,
                        'capacity' => (int) $storage->capacity,
                        'display' => (int) $storage->capacity . ' ' . $storage->name,
                    ];
                });
            }),

            // Color options (first for display, all for details)
            'color' => $colorDisplay,
            'colors' => $this->whenLoaded('colors', function () {
                return $this->colors->map(function ($color) {
                    return [
                        'id' => $color->id,
                        'name' => $color->name,
                        'code' => $color->code,
                    ];
                });
            }),

            // Gallery images (for product details)
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image' => url($image->image),
                    ];
                });
            }),

            // Protection services (for product details)
            'protection_services' => $this->whenLoaded('protectionServices', function () {
                return $this->protectionServices->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                        'description' => $service->description,
                        'price' => (float) $service->price,
                    ];
                });
            }),

            // Accessories (for product details)
            'accessories' => $this->whenLoaded('accessories', function () {
                return $this->accessories->map(function ($accessory) {
                    return [
                        'id' => $accessory->id,
                        'name' => $accessory->name,
                        'description' => $accessory->description,
                        'price' => (float) $accessory->price,
                    ];
                });
            }),

            // Description (for product details)
            'description' => $this->when($this->relationLoaded('images'), $this->description),
        ];
    }
}
