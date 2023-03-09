<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HttpResponses {
    protected function success($data , $message = null , $code = 200){
        return response()->json([
            "status" => "request was successful" ,
            "message" => $message,
            "data" => $data
        ] , $code);
    }

    protected function errors ($message = null , $code){
        return response()->json([
            "status" => "Errors has occurred...." ,
            "message" => $message,
        ] , $code);
    }

    protected function userHave($thing){
        return Auth::user()->id === $thing->user_id;
    }

    protected function isAdmin(){
        return Auth::user()->role->name === 'admin';
    }

    protected function isSealer(){
        return Auth::user()->role->name === 'sealer';
    }
}
