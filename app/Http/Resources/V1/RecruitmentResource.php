<?php

namespace App\Http\Resources\V1;

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
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'mobile' => $this->user->mobile,
            'birthday' => $this->birthday,
            'martial_status' => $this->martial_status,
            'address' => $this->address,
            'activity' => $this->activity,
            'eduction_status' => $this->eduction_status,
            'ability_description' => $this->ability_description,
            'shaba_number' => $this->shaba_number,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'code_meli' => $this->code_meli,
            'mentor_id' => $this->mentor_id,
        ];
    }
}
