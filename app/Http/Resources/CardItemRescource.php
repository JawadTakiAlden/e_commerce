<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardItemRescource extends JsonResource
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
                'count' => $this->count,
                'unit_price' => $this->unit_price,
                'total_price' => $this->total->price,
                'is_shipped' => $this->is_shipped
            ],
            'relationships' => [
                'product' => ProductResource::collection($this->product)
            ]
        ];
    }
}
