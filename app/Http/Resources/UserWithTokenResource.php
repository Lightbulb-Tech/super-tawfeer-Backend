<?php

namespace App\Http\Resources;

class UserWithTokenResource extends UserResource
{
    public function toArray($request)
    {
        $baseData = parent::toArray($request);

        return array_merge($baseData, [
            'token' => isset($this->token) ? 'Bearer ' . $this->token : '',
        ]);
    }
}
