<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureDeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'thumbnail' => $this->thumbnail,
            'is_featured' => $this->is_featured,
            'subcategory' => $this->whenLoaded('buySubcategory', function () {
                return [
                    'id' => $this->buySubcategory->id,
                    'name' => $this->buySubcategory->name,
                ];
            }),
            'condition' => $this->whenLoaded('condition', function () {
                return [
                    'id' => $this->condition->id,
                    'name' => $this->condition->name,
                ];
            }),
            'colors' => $this->whenLoaded('colors', function () {
                return $this->colors->map(fn($color) => [
                    'id' => $color->id,
                    'name' => $color->name,
                ]);
            }),
            'storages' => $this->whenLoaded('storages', function () {
                return $this->storages->map(fn($storage) => [
                    'id' => $storage->id,
                    'name' => $storage->name,
                    'capacity' => $storage->capacity,
                ]);
            }),
            'protection_services' => $this->whenLoaded('protectionServices', function () {
                return $this->protectionServices->map(fn($service) => [
                    'id' => $service->id,
                    'name' => $service->name,
                ]);
            }),
            'accessories' => $this->whenLoaded('accessories', function () {
                return $this->accessories->map(fn($accessory) => [
                    'id' => $accessory->id,
                    'name' => $accessory->name,
                ]);
            }),
        ];
    }
}
