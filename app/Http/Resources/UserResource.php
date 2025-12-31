<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'name' => $this->first_name . ' ' . $this->last_name,
            'phone' => (string)$this->phone,
            'phone_code' => (string)'+' . $this->phone_code,
            'email' => (string)$this->email,
            'image' => show_file($this->image),
            'lat' => (double)$this->lat,
            'lon' => (double)$this->lon,
            'points' => (double)$this->points,
            'checked_address' => AddressResource::make($this->address),
            'register_from' => (string)$this->register_from,
            'register_type' => (string)$this->register_type,
            'social_id' => (string)$this->social_id,
        ];
    }
}
