<?php

namespace App\Transformers;

use App\SellCarExamination;

class SellCarExaminationTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(SellCarExamination $sellCarExamination)
    {
        return [
            'title' => $sellCarExamination->examination->name,
            'category' => $sellCarExamination->examination->category,
            'pic_url' => $sellCarExamination->pic_url,
            'passed' => $sellCarExamination->passed,
            'remarks' => $sellCarExamination->remarks
        ];
    }
}