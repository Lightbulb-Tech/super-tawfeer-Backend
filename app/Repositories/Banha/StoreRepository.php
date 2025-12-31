<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Store;
use App\Repositories\MainRepository;

class StoreRepository extends MainRepository
{
    public function __construct(Store $model)
    {
        $this->model = $model;
        $this->columsFile = ['logo', 'cover_image'];
        $this->fileFolder = 'store_images';
    }

}
