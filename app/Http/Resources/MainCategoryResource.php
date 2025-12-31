<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => (integer)$this->id,
            'title' => (string)$this->title,
            'image' => show_file($this->image),
        ];
        if (isset($this->mainCategory)) {
            $data['mainCategory'] = @$this->mainCategory->title;
        }
        return $data;


    }
}
