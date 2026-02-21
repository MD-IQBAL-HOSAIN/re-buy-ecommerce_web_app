<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductNameResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
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
            'colors' => $this->whenLoaded('colors', function () {
                return $this->colors->map(function ($color) {
                    return [
                        'id' => $color->id,
                        'name' => $color->name,
                        'code' => $color->code,
                    ];
                });
            }),
        ];
    }
}
