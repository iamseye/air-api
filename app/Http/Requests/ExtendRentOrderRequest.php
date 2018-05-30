<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtendRentOrderRequest extends FormRequest
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
            'rent_order_id' => 'required|integer',
            'end_date' => 'required',
            'buy_insurance' => 'required|boolean'
        ];
    }
}
