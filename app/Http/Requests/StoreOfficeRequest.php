<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfficeRequest extends FormRequest
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
            'affiliate_id' => 'required|unique:offices|integer',
            'name' => 'required|max:255',
            'latitude' => 'required|decimal:4,7',
            'longitude' => 'required|decimal:4,7'
        ];
    }
}
