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
            'user_id' => 'required|integer',
            'sell_car_id' => 'required|integer',
            'is_pickup_at_car_center' => 'boolean',
            'pickup_home_city' => 'string',
            'pickup_home_area' => 'string',
            'pickup_home_address' => 'string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'pickup_time' => 'required',
            'remarks' => 'string',
            'status' => 'string',
            'promo_code' => 'string',
            'insurance_id' => 'integer'
        ];
    }
}
