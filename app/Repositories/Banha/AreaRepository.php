<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Area;
use App\Repositories\MainRepository;

class AreaRepository extends MainRepository
{
    public function __construct(Area $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }
    public function getDataForDataTable()
    {
        return $this->model->query()->select('areas.id', 'area_translations.title', 'areas.country_id', 'areas.governorate_id', 'areas.shipping_price', 'areas.is_active')
            ->join('area_translations', function ($join) {
                $join->on('areas.id', '=', 'area_translations.area_id')
                    ->where('area_translations.locale', app()->getLocale());
            })
            ->where("areas.governorate_id", '!=', null)
            ->orderBy('areas.created_at', 'desc');
    }
    public function getAreas()
    {
        return $this->get()->where('governorate_id', '!=', null)->where('is_active', '=', 1);
    }

}
