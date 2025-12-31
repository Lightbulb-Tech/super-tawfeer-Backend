<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Cart;
use App\Models\Banha\Faq;
use App\Repositories\MainRepository;

class CartRepository extends MainRepository
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }
}
