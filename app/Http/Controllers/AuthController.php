<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;




// Done
class AuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUser $request){
        $request->validated($request->all());

        $user = User::create($request->all());

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->first_name)->plainTextToken
        ]);
    }
    public function login(LoginUser $request){
        $request->validated($request->all());


        if (!Auth::attempt($request->only('email','password'))){
            return $this->errors("Credentials do not match..",401);
        }

        $user = User::where('email' , $request->email)->first();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->first_name)->plainTextToken
        ]);

    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'you have been logout successfully and your token has been deleted'
        ]);
    }

    public function webLogin(){
        return view('auth.login');
    }
}
