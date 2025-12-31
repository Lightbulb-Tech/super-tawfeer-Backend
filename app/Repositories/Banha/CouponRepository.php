<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Coupon;
use App\Models\Banha\Faq;
use App\Repositories\MainRepository;

class CouponRepository extends MainRepository
{
    public function __construct(Coupon $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }



}
