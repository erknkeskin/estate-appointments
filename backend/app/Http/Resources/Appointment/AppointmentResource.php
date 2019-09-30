<?php

namespace App\Http\Resources\Appointment;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'customer_id' => $this->customer_id,
            'home_id' => $this->home_id,
            'user_id' => $this->user_id,
            'note' => $this->note,
            'start' => $this->start,
            'status' => $this->status
        ];
    }
}
