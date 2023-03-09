<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeFilter($query , array $filters){
        $query->when($filters['category_id'] ?? false , fn($query , $category_id) =>
            $query
            ->whereHas('categories' , fn() =>
                $query
                    ->where('category_id' , $category_id)
            )
        );

        $query->when($filters['less_price']  ?? false , fn($query , $less_price) =>
            $query
                ->where('price' , '>=' , $less_price )
        );

        $query->when($filters['top_price'] ?? false , fn($query , $top_price) =>
            $query
                ->where('price' , '<=' , $top_price )
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }
}
