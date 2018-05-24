<?php

namespace App\Transformers;

use App\SellCar;

class SellCarTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'car_unavailable_dates',
        'rent_orders'
    ];

    public function transform(SellCar $sellCar)
    {
        return [
            'id' => $sellCar->id,
            'available_from' => $sellCar->available_from,
            'available_to' => $sellCar->available_to,
        ];
    }

    public function includeCarUnavailableDates(SellCar $sellCar)
    {
        return $this->collection($sellCar->unavailableDates, new SellCarUnavailableDateTransformer());
    }

    public function includeRentOrders(SellCar $sellCar)
    {
        return $this->collection($sellCar->rentOrders, new RentOrderTransformer());
    }
}
