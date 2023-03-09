<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class ProductController extends Controller
{
    use HttpResponses;

    public function index(){
        if ($this->isAdmin()){
            $publishedProducts = Product::latest()
                ->with('productImages' , 'categories')
                ->where('status' , 'published')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            $newProducts = Product::latest()
                ->with('productImages' , 'categories')
                ->where('status' , 'new')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            $rejectedProducts = Product::latest()
                ->with('productImages' , 'categories')
                ->where('status' , 'rejected')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            return $this->success([
                'published_products' => $publishedProducts,
                'new_products' => $newProducts,
                'rejected' => $rejectedProducts
            ] ,  'request was successfully');
        }
        if ($this->isSealer()){
            $publishedProducts = Product::latest()
                ->where('user_id' , Auth::user()->id)
                ->where('status' , 'published')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            $newProducts = Product::latest()
                ->where('user_id' , Auth::user()->id)
                ->where('status' , 'new')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            $rejectedProducts = Product::latest()
                ->where('user_id' , Auth::user()->id)
                ->where('status' , 'rejected')
                ->filter(request(['category' , 'less_price' , 'top_price']))
                ->get();
            return $this->success([
                'published_products' => $publishedProducts,
                'new_products' => $newProducts,
                'rejected' => $rejectedProducts
            ] ,  'request was successfully');
        }
        $products = Product::latest()->where('status' , 'published')->filter(request(['category' , 'less_price' , 'top_price']))->get();
        return ProductResource::collection($products);
    }

    public function store(StoreProduct $request){
        if(!$this->isSaller() || !$this->isAdmin() ){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $request->validated($request->all());
        $product = Product::create($request->except(['category_ids']));
        foreach (json_decode($request->category_ids) as $category_id){
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category_id
            ]);
        }
        foreach (json_decode($request->sizes_ids) as $size_id){
            ProductSize::create([
                'product_id' => $product->id,
                'size_id' => $size_id
            ]);
        }
        if ($images  = $request->file('images')){
            foreach ($images as $image){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image
                ]);
            }
        }
        return $this->success($product , 'product created successfully');
    }

    public function update(UpdateProduct $request , Product $product){
        if (!$this->isSealer() || !$this->isAdmin()){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        if ($this->isSealer()){
            if (!$this->userHave()){
                return $this->errors('you are not authorize to do this request' , 401);
            }
        }
        $request->validated($request->all());
        $product->update($request->all());
        return $this->success($product , 'product updated successfully');
    }

    public function destroy(Product $product){
        if (!$this->isSealer() || !$this->isAdmin()){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        if ($this->isSealer()){
            if (!$this->userHave()){
                return $this->errors('you are not authorize to do this request' , 401);
            }
        }
        $product->delete();
        return $this->success('' , 'product deleted successfully');
    }

    public function like(Product $product){
        $product->update([
            'number_of_liked' => $product->number_of_liked + (int)request('like_value')
        ]);
        return $this->success('' , 'thank you for your like');
    }

}
