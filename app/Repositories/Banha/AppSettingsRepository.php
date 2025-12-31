<?php

namespace App\Repositories\Banha;

use App\Models\Banha\AppSetting;
use App\Repositories\MainRepository;

class AppSettingsRepository extends MainRepository
{
    public function __construct(AppSetting $model)
    {
        $this->model = $model;
        $this->columsFile = ['logo'];
        $this->fileFolder = 'app_settings/logos';
    }


}
