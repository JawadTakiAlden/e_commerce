<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageProductRequest;
use App\Models\Image;
use App\Models\ProductImage;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductImageController extends Controller
{
    use HttpResponses;
    public function store(StoreImageProductRequest $request){
        if (Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $request->validated($request->all());

        $product_image = ProductImage::create($request->all());

        return $this->success($product_image , 'images added successfully');
    }

    public function destroy(ProductImage $productImage){
        if (Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $productImage->delete();
    }
}
