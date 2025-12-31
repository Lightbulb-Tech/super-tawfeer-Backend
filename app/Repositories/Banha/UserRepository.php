<?php

namespace App\Repositories\Banha;

use App\Models\Banha\User;
use App\Repositories\MainRepository;

class UserRepository extends MainRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'users_images';
    }


}
