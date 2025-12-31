<?php

namespace App\Services\TamoTech;

use App\Models\Permission;
use App\Services\MainService;
use App\Traits\ImageTrait;

class PermissionService extends MainService
{
    use ImageTrait;

    public function __construct(Permission $model)
    {
        $this->model = $model;
        $this->fileFolder = 'adminsImages';
    }



}
