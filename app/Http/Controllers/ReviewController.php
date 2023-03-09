<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use HttpResponses;
    public function index(){
        $reviews = Review::where('product_id' , request('product_id'))->get();
        return ReviewResource::collection($reviews);
    }

    public function store(StoreReviewRequest $request){
        $request->validated($request->all());

        $review = Review::create(array_merge($request->all() , ['user_id' => Auth::user()->id]));

        return $this->success($review , 'one review added successfully');
    }

    public function destroy(Review $review){
        if ($review->user_id !== Auth::user()->id){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $review->delete();
        return $this->success('' , 'your review deleted successfully');
    }
    public function like(Review $review){

        $review->update([
            'number_of_liked' => $review->number_of_liked + (int)request('like_value')
        ]);
        return $this->success('' , 'thank you for your like');
    }
}
