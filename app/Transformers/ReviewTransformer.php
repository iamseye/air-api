<?php

namespace App\Transformers;

use App\Review;

class ReviewTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Review $review)
    {
        return [
            'sell_car_id' => $review->start,
            'rent_order_id' => $review->rent_order_id,
            'stars' => $review->stars,
            'review' => $review->review
        ];
    }
}
