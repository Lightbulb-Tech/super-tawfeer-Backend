<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'operation' => (string)@$this->operation,
            'amount' => (double)$this->amount,
            'status' => (string)$this->status,
            'date' => (string)$this->created_at->format('Y-m-d'),
        ];


    }
}
