<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Offer;
use App\Models\Banha\ProductImage;
use App\Repositories\MainRepository;

class OfferRepository extends MainRepository
{
    public function __construct(Offer $model)
    {
        $this->model = $model;
    }


}
