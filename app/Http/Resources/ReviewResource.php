<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
                'user_id' => $this->user_id,
                'product_id' => $this->product_id,
                'review' => $this->review,
                'number_of_liked' => $this->number_of_liked
            ],
            'relationships' => [
                'user_name' => $this->user->first_name . ' ' . $this->user->last_name,
                'user_image' => $this->user->image
            ]
        ];
    }
}
