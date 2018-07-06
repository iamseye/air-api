<?php

namespace App\Transformers;

use App\SellCar;

class SellCarTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'car_unavailable_dates',
        'rent_orders',
        'car',
        'car_center',
        'sell_car_examination'
    ];

    public function transform(SellCar $sellCar)
    {
        return [
            'id' => $sellCar->id,
            'available_from' => $sellCar->available_from,
            'available_to' => $sellCar->available_to,
            'buy_price' => $sellCar->buy_price,
            'rent_price' => $sellCar->rent_price,
            'description' => $sellCar->description,
            'class' => $sellCar->class,
            'mileage' => $sellCar->mileage,
            'examination_date' => $sellCar->examination_date
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

    public function includeCar(SellCar $sellCar)
    {
        return $this->item($sellCar->car, new CarTransformer());
    }

    public function includeCarCenter(SellCar $sellCar)
    {
        return $this->item($sellCar->carCenter, new CarCenterTransformer());
    }

    public function includeSellCarExamination(SellCar $sellCar)
    {
        return $this->collection($sellCar->sellCarExamination, new SellCarExaminationTransformer());
    }
}
