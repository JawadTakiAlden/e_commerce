<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'quantity_in_stock' => $this->quantity_in_stock,
                'unit_price' => $this->unit_price,
                'number_of_liked'  => $this->number_of_liked,
                'number_of_order' => $this->number_of_order,
            ]
            ,
            'relationship' => [
                'images' => $this->productImages
            ]
        ];
    }
}
