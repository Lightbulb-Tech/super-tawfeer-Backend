<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Order;
use App\Repositories\MainRepository;

class OrderRepository extends MainRepository
{
    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getOrders(array $status, $user)
    {
        return $this->model->whereIn('status', $status)->where('user_id', $user->id)->latest();
    }
    public function getOrdersForDataTable(array $status)
    {
        return $this->model->query()->with(['user'])
            ->whereIn('status', $status)->latest();
    }


}
