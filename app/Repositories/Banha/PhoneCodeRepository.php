<?php

namespace App\Repositories\Banha;

use App\Models\Banha\PhoneCode;
use App\Repositories\MainRepository;

class PhoneCodeRepository extends MainRepository
{
    public function __construct(PhoneCode $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }




}
