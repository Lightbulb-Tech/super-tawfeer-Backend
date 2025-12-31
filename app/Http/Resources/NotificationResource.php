<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'form_user_id' => (string)$this->form_user_id,
            'form_user_table' => (string)$this->form_user_table,
            'to_user_id' => (string)$this->to_user_id,
            'to_user_table' => (string)$this->to_user_table,
            'title' => (string)$this->title,
            'message' => (string)$this->message,
            'is_read' => (boolean)$this->is_read,
            'action' => (string)$this->action,
            'operation_id' => (string)$this->operation_id,
            'created_at' => $this->created_at
                ? Carbon::parse($this->created_at)->locale(App::getLocale())->diffForHumans()
                : null, 'updated_at' => (string)$this->updated_at,
        ];


    }
}
