<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Brand;
use App\Repositories\MainRepository;

class BrandRepository extends MainRepository
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'brand_images';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('brands.id', 'brand_translations.title', 'brands.image')
            ->join('brand_translations', function ($join) {
                $join->on('brands.id', '=', 'brand_translations.brand_id')
                    ->where('brand_translations.locale', app()->getLocale());
            });
    }
}
