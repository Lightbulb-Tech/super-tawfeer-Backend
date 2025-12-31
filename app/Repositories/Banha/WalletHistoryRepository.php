<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Wallet;
use App\Models\Banha\WalletHistory;
use App\Repositories\MainRepository;

class WalletHistoryRepository extends MainRepository
{
    public function __construct(WalletHistory $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }


}
