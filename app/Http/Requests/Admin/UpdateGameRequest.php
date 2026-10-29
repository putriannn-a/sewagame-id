<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'platform_id'      => ['required', 'exists:platforms,id'],
            'title'            => ['required', 'string', 'max:150'],
            'condition'        => ['required', 'in:bnib,like_new,good'],
            'stock'            => ['required', 'integer', 'min:0'],
            'rent_daily_price' => ['required', 'numeric', 'min:1000'],
            'deposit_amount'   => ['required', 'numeric', 'min:0'],
            'cover_image'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active'        => ['required', 'boolean'],
        ];
    }
}