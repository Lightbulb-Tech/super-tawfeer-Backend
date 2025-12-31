<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Address;
use App\Models\Banha\PointHistory;
use App\Repositories\MainRepository;

class PointHistoryRepository extends MainRepository
{
    public function __construct(PointHistory $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
