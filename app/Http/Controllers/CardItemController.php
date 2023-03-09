<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardItemRequest;
use App\Http\Requests\UpdateCardItemRequest;
use App\Http\Resources\CardItemRescource;
use App\Models\CardItem;
use App\Models\Product;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardItemController extends Controller
{
    use HttpResponses;
    public function index(){
        $cardItems = CardItem::where('user_id' , Auth::user()->id)->get();
        return CardItemRescource::collection($cardItems);
    }

    public function store(StoreCardItemRequest $request){

        // validate coming request
        $request->validated($request->all());
        // extract product related to card item
        $product = Product::where('id' , $request->product_id)->get();
        // extract quantity of product
        $quantity_in_stock = $product->quantity_in_stock;
        // extract ordered quantity from request
        $count = $request->count;

        // check if we have enough quantity to this order
        if (!$quantity_in_stock >= $count){
            return $this->errors('sorry , the quantity of product is not enough');
        }

        // if we have => update product in new quantity
        $product->update([
            'quantity_in_stock' => $quantity_in_stock - $count
        ]);

        // create card item info
        $cardItemInfo = [
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'count' => $count,
            'unit_price' => $product->unit_price,
            'total_price' => $request->count ? $product->unit_price * $count : $product->unit_price
        ];

        // create card item in database
        $cardItem = CardItem::create($cardItemInfo);

        return $this->success($cardItem , 'card item added successfully');
    }

    public function update(UpdateCardItemRequest $request , CardItem $cardItem){
        if (!$this->userHave($cardItem)){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $request->validated($request->all());

        $new_count = (int)$request->count;

        if ($new_count === 0) {
            return $this->errors('count must be at least one' , 403);
        }

        $newTotalPrice = $cardItem->unit_price * $new_count ;

        $cardItem->update([
            'count' => $new_count,
            'total_price' => $newTotalPrice
        ]);
    }

    public function destroy(CardItem $cardItem){
        if (!$this->userHave($cardItem)){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $cardItem->delete();
        return $this->success('' , 'one cardItem has been deleted successfully');
    }
}
