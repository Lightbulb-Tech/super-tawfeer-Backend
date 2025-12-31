<?php

namespace App\Repositories\Banha;

use App\Models\Banha\OrderCategory;
use App\Repositories\MainRepository;

class OrderCategoryRepository extends MainRepository
{
    public function __construct(OrderCategory $model)
    {
        $this->model = $model;
        $this->columsFile = [''];
        $this->fileFolder = '';
    }

}
