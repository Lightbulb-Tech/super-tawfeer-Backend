<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Faq;
use App\Models\Banha\Vehicle;
use App\Repositories\MainRepository;

class VehicleRepository extends MainRepository
{
    public function __construct(Vehicle $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'vehicles_images';
    }

}
