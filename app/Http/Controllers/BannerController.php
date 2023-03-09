<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use HttpResponses;
    public function index(){
        $banners = Banner::all();
        return BannerResource::collection($banners);
    }


    public function store(StoreBannerRequest $request){
        if (!$this->ifAdmin()){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $request->validated($request->all());
        $banner = Banner::create($request->all());
        return $this->success($banner , 'one banner added successfully');
    }


    public function update(UpdateBannerRequest $request , Banner $banner){
        if (!$this->ifAdmin() || !$request->all()){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $request->validated($request->all());
        $banner->update($request->all());
        return $this->success($banner , 'one banner updated successfully');
    }


    public function destroy(Banner $banner){
        if (!$this->ifAdmin()){
            return $this->errors('you are not authorize to do this request' , 401);
        }
        $banner->delete();
        return $this->success( '','one banner deleted successfully');
    }
}
