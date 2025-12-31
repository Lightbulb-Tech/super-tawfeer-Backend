<?php

namespace App\Services\TamoTech;

use App\Models\TamoTech\Command;
use App\Services\MainService;

class CommandService extends MainService
{
    public function __construct(Command $model)
    {
        $this->model = $model;
    }

}
