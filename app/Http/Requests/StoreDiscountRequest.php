<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'type' => ['required', 'in:global,event'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_amount' => ['required', 'numeric'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:Draft,Public'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama diskon tidak boleh kosong.',
            'type.required' => 'Tipe diskon tidak boleh kosong.',
            'discount_type.required' => 'Tipe diskon tidak boleh kosong.',
            'discount_amount.required' => 'Jumlah diskon tidak boleh kosong.',
            'start_date.date' => 'Tanggal mulai tidak valid.',
            'end_date.date' => 'Tanggal akhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            'status.required' => 'Status diskon tidak boleh kosong.',
            'status.in' => 'Status diskon tidak valid.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('discount_type');
            $amount = $this->input('discount_amount');

            if ($type === 'percentage' && ($amount < 1 || $amount > 100)) {
                $validator->errors()->add('discount_amount', 'Untuk diskon tipe persentase, nilainya harus antara 1 dan 100.');
            }

            if ($type === 'fixed' && $amount < 1) {
                $validator->errors()->add('discount_amount', 'Untuk diskon tipe nominal, nilainya harus minimal 1 rupiah.');
            }
        });
    }
}
