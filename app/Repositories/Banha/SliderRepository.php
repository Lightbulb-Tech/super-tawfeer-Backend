<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Slider;
use App\Repositories\MainRepository;

class SliderRepository extends MainRepository
{
    public function __construct(Slider $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'slider_images';
    }
}
