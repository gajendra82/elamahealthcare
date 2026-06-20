<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'category' => ['nullable', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:2000'],
            'composition' => ['nullable', 'string'],
            'dosage' => ['nullable', 'string', 'max:255'],
            'packaging' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'format' => ['nullable', 'string', 'max:255'],
        ];
    }
}
