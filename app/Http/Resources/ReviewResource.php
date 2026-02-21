<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'language_id' => $this->language_id,
            'language_name' => $this->whenLoaded('language', fn() => $this->language?->name),
            'product_id' => $this->product_id,
            'product_name' => $this->whenLoaded('product', fn() => $this->product?->name),
            'user_id' => $this->user_id,
            'user_name' => $this->whenLoaded('user', fn() => $this->user?->name),
            'rating' => $this->rating,
            'review_text' => $this->review_text,
        ];
    }
}
