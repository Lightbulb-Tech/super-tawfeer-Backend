<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Address;
use App\Models\Banha\Wallet;
use App\Repositories\MainRepository;

class WalletRepository extends MainRepository
{
    public function __construct(Wallet $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
