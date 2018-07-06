<?php

namespace App\Transformers;

use App\SellCarAccessory;

class SellCarAccessoryTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(SellCarAccessory $sellCarAccessory)
    {
        return [
            'name' => $sellCarAccessory->accessory->name,
        ];
    }
}
