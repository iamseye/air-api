<?php

namespace App\Transformers;

use App\Area;

class AreaTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Area $area)
    {
        return [
            'name' => $area->name,
        ];
    }
}
