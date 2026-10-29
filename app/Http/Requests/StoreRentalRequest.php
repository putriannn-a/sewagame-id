<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Hanya customer yang sudah login
    }

    public function rules(): array
    {
        $allowedDurations = config('rental.allowed_durations', [3, 7, 14]);

        return [
            'game_id'         => ['required', 'exists:games,id'],
            'duration_days'   => ['required', 'integer', Rule::in($allowedDurations)],
            'delivery_method' => ['required', Rule::in(['pickup', 'courier'])],
            'payment_method'  => ['required', Rule::in(['qris', 'bank', 'ewallet'])],
        ];
    }

    public function messages(): array
    {
        return [
            'game_id.required'         => 'Pilihan game tidak valid.',
            'game_id.exists'           => 'Game yang dipilih tidak ditemukan di database.',
            'duration_days.required'   => 'Durasi sewa wajib dipilih.',
            'duration_days.in'         => 'Pilihan durasi harus 3, 7, atau 14 hari.',
            'delivery_method.required' => 'Metode pengambilan wajib dipilih.',
            'payment_method.required'  => 'Metode pembayaran wajib dipilih.',
        ];
    }
}