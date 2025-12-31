<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Address;
use App\Models\OrderCancellation;
use App\Repositories\MainRepository;

class OrderCancellationRepository extends MainRepository
{
    public function __construct(OrderCancellation $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
