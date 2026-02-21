<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'buy_subcategory_id' => 'nullable|integer|exists:buy_subcategories,id',
            'condition_id' => 'nullable|integer|exists:conditions,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'old_price' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'storage_id' => 'nullable|integer|exists:storages,id',
            'protection_services' => 'nullable|array',
            'protection_services.*' => 'exists:protection_services,id',
            'accessories' => 'nullable|array',
            'accessories.*' => 'exists:accessories,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'buy_subcategory_id.exists' => 'The selected subcategory is invalid.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'image.image' => 'The thumbnail must be an image.',
            'image.mimes' => 'The thumbnail must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The thumbnail may not be greater than 5MB.',
            'images.*.image' => 'Each gallery image must be an image.',
            'images.*.mimes' => 'Gallery images must be files of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each gallery image may not be greater than 10MB.',
        ];
    }
}
