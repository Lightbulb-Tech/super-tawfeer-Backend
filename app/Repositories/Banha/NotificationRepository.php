<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Area;
use App\Models\Banha\Notification;
use App\Repositories\MainRepository;

class NotificationRepository extends MainRepository
{
    public function __construct(Notification $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

}
