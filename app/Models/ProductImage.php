<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'image' . '.' . $image->extension();

        $image->move(public_path('ProductImages') , $newImageName);
        return $this->attributes['image'] =  '/ProductImages/' . $newImageName;
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
