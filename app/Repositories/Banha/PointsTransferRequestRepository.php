<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Address;
use App\Models\Banha\PointTransferRequest;
use App\Repositories\MainRepository;

class PointsTransferRequestRepository extends MainRepository
{
    public function __construct(PointTransferRequest $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
