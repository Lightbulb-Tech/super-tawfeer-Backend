<?php

namespace App\Repositories\Banha;

use App\Models\Banha\ExternalOrderDetail;
use App\Repositories\MainRepository;

class ExternalOrderDetailsRepository extends MainRepository
{
    public function __construct(ExternalOrderDetail $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'external_order_details_images';
    }

    public function storeExternalOrderDetails($data): bool
    {
        foreach ($data['order_details'] as $order_detail) {
            $order_detail['external_order_id'] = $data['external_order_id'];
            $this->storeWithFiles($order_detail);
        }
        return true;
    }


}
