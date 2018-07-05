<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchSellCarRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'area' => 'nullable|array',
            'vehicle_type' => 'nullable|array',
            'brand' => 'nullable|string',
            'series' => 'nullable|string',
            'series_model' => 'nullable|string',
            'year' => 'nullable|integer',
            'price' => 'nullable|array',
            'start_date' => 'nullable|integer',
            'end_date' => 'nullable|integer'
        ];
    }
}
