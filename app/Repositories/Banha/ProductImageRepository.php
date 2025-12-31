<?php

namespace App\Repositories\Banha;

use App\Models\Banha\ProductImage;
use App\Repositories\MainRepository;

class ProductImageRepository extends MainRepository
{
    public function __construct(ProductImage $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'product_images';
    }

    public function storeProductImages($product_id, $images)
    {
        foreach ($images as $image) {
            $this->storeWithFiles([
                'product_id' => $product_id,
                'image' => $image,
            ]);
        }
        return true;

    }


}
