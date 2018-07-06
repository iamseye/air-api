<?php

namespace App\Transformers;

use App\SellCarEquipment;

class SellCarEquipmentTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(SellCarEquipment $sellCarEquipment)
    {
        return [
            'title' => $sellCarEquipment->equipment->name,
            'category' => $sellCarEquipment->equipment->category,
            'has_equipment' => $sellCarEquipment->has_equipment,
            'value' => $sellCarEquipment->value
        ];
    }
}
