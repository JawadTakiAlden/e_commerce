<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use HttpResponses;
    public function store(StoreRoleRequest $request){
        if (!$this->ifAdmin()){
            return $this->errors('you are nor authorize to do this request' , 401);
        }
        $request->validated($request->all());
        $role = Role::create($request->all());
        return $this->success($role , 'one role added successfully');
    }

    public function index(){
        $roles = Role::all();
        return RoleResource::collection($roles);
    }
}
