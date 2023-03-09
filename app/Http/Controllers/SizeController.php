<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    use HttpResponses;
    public function index(){
        $sizes = Size::all();
        return SizeResource::collection($sizes);
    }
    public function store(StoreSizeRequest $request){
        if(Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $request->validated($request->all());

        $size = Size::create($request->all());

        return $this->success($size , 'one size added successfully');

    }
    public function update(StoreSizeRequest $request , Size $size){
        if(Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $request->validated($request->all());

        $size->update($request->all());

        return $this->success($size , 'one size updated successfully');
    }
    public function destroy(Size $size){
        if(Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $size->delete();

        return $this->success('' , 'one size deleted successfully');
    }
}
