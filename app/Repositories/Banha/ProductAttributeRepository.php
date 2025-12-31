<?php

namespace App\Repositories\Banha;

use App\Models\Banha\ProductAttribute;
use App\Repositories\MainRepository;

class ProductAttributeRepository extends MainRepository
{
    public function __construct(ProductAttribute $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getDataForDataTable($product_id)
    {
        return $this->model->query()->select('product_attributes.id', 'product_attributes.product_id', 'product_attributes.attribute_value', 'product_attribute_translations.attribute_name')
            ->join('product_attribute_translations', function ($join) use ($product_id) {
                $join->on('product_attributes.id', '=', 'product_attribute_translations.product_attr_id')
                    ->where('product_attribute_translations.locale', app()->getLocale())
                    ->where('product_attributes.product_id', '=', $product_id);
            })->orderBy('product_attributes.created_at', 'desc');
    }


}
