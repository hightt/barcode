<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'barcode_text' => ['required', 'min:0', 'max:85'],
            'barcode_type' => ['required', 'string'],
            'barcode_width' => ['required', 'numeric', 'gt:0'],
            'barcode_height' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
