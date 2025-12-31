<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Order;
use App\Models\Banha\OrderDetail;
use App\Repositories\MainRepository;

class OrderDetailsRepository extends MainRepository
{
    public function __construct(OrderDetail $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getOrders(array $status, $user)
    {
        return $this->model->whereIn('status', $status)->where('user_id', $user->id)->latest();
    }


}
