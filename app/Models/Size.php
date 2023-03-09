<?php

namespace App\Models;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Resources\SizeResource;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}
