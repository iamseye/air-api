<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Review;
use App\RentOrder;
use App\Traits\ResponseTrait;
use App\Transformers\ReviewTransformer;

class ReviewController extends Controller
{
    use ResponseTrait;

    public function store(StoreReviewRequest $request)
    {
        $order = RentOrder::findOrFail($request->rent_order_id);

        if ($order->status !== 'FINISHED') {
            return $this->returnError('您還不能為此車輛給予評論，請先完成體驗');
        }

        if (!is_null($order->review)) {
            return $this->returnError('您已評論過此訂單');
        }

        $review = new Review();
        $review->user_id = $request->user_id;
        $review->rent_order_id = $request->rent_order_id;
        $review->sell_car_id = $order->sellCar->id;
        $review->stars = $request->stars;
        $review->review = $request->review;
        $review->save();

        return fractal()
            ->item($review)
            ->transformWith(new ReviewTransformer())
            ->toArray();
    }
}
