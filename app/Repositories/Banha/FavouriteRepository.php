<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Faq;
use App\Models\Banha\Favourite;
use App\Repositories\MainRepository;

class FavouriteRepository extends MainRepository
{
    public function __construct(Favourite $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }




}
