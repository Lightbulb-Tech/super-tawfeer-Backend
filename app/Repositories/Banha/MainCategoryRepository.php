<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Category;
use App\Repositories\MainRepository;

class MainCategoryRepository extends MainRepository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'main_categories_images';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('categories.id', 'categories.is_active', 'categories.image', 'category_translations.title')
            ->join('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', app()->getLocale())
                    ->where('categories.main_category_id', '=', null);
            })->orderBy('categories.created_at', 'desc');
    }
}
