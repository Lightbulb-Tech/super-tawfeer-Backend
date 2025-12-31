<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppSettingsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'email' => (string)$this->email,
            'phone' => (string)@$this->phone,
            'app_commission' => (double)@$this->app_commission,
            'point_price' => (double)@$this->point_price,
            'address' => (string)@$this->address,
            'app_name' => (string)@$this->app_name,
            'logo' => (string)show_file($this->logo),
        ];


    }
}
