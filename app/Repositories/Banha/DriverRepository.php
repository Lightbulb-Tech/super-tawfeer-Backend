<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Driver;
use App\Repositories\MainRepository;

class DriverRepository extends MainRepository
{
    public function __construct(Driver $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'driver_images';
    }

    public function getMostDriversDeliveriesDataForDataTable()
    {
        return $this->model->query()->whereHas('completedOrder')->latest();

    }

}
