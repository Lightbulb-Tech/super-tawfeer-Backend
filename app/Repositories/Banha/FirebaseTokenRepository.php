<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Faq;
use App\Models\Banha\FirebaseToken;
use App\Repositories\MainRepository;

class FirebaseTokenRepository extends MainRepository
{
    public function __construct(FirebaseToken $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }
    public function storeToken($user_id, $data)
    {
        $data['user_id'] = $user_id;

        $attributes = [
            'token' => $data['token'],
            'type' => $data['type']
        ];

        $exist = $this->model->where('user_id',$user_id)
            ->where('type', $data['type'])
            ->first();

        if (isset($exist)) {
            $exist->update($attributes);
        } else {
            $attributes['user_id'] = $user_id;
            $this->model->create($attributes);
        }

        return $data;
    }


}
