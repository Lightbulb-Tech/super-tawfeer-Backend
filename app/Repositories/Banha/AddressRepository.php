<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Address;
use App\Repositories\MainRepository;

class AddressRepository extends MainRepository
{
    public function __construct(Address $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
