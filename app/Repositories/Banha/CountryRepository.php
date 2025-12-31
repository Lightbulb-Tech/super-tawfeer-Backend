<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Country;
use App\Repositories\MainRepository;

class CountryRepository extends MainRepository
{
    public function __construct(Country $model)
    {
        $this->model = $model;
        $this->columsFile = [];
        $this->fileFolder = '';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('countries.id', 'country_translations.title')
            ->join('country_translations', function ($join) {
                $join->on('countries.id', '=', 'country_translations.country_id')
                    ->where('country_translations.locale', app()->getLocale());
            })->orderBy('countries.created_at', 'desc');
    }
}
