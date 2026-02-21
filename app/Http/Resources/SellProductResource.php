<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellProductResource extends JsonResource
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
            'language_id' => $this->language_id,
            'buy_subcategory_id' => $this->buy_subcategory_id,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'slug' => $this->slug,
            'image' => $this->image,
        ];
    }
}
