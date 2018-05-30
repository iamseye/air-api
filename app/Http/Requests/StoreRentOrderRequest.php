<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentOrderRequest extends FormRequest
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
            'sell_car_id' => 'required|integer',
            'pickup_home_address' => 'string',
            'start_date' => 'required',
            'end_date' => 'required',
            'promo_code' => 'string',
            'buy_insurance' => 'required|boolean'
        ];
    }
}