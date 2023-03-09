<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateUserImage;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;
    public function update(UpdateUser $request , User $user){
        $request->validated($request->all());

        if(Auth::user()->id !== $user->id){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $user->update($request->all());

        return $this->success($user);
    }
    public function updateImage(UpdateUserImage $request , User $user){
        $request->validated($request->image);
        if(Auth::user()->id !== $user->id){
            return $this->errors('you are not authorize to do this request' , 401);
        }

        $user->update($request->all());

        return $this->success('' , 'your image updated successfully');
    }
    public function profile(){
        return $this->success(Auth::user());
    }

}
