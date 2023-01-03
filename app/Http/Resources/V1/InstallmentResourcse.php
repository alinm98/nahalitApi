<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResourcse extends JsonResource
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
            'price' => $this->price,
            'description' => $this->description,
            'number_of_installment' => $this->number_of_installment,
            'status' => $this->status,
            'payments' => $this->payments,
            'deadline' => $this->deadline,
        ];
    }
}
