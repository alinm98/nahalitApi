<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'martial_status' => $this->martial_status,
            'address' => $this->address,
            'phone' => $this->phone,
            'activity' => $this->activity,
            'eduction_status' => $this->eduction_status,
            'ability_description' => $this->ability_description,
            'shaba_number' => $this->shaba_number,
            'status' => $this->status,
        ];
    }
}
