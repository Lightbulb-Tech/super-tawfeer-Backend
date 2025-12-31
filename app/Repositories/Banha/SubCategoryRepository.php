<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Category;
use App\Repositories\MainRepository;

class SubCategoryRepository extends MainRepository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'sub_categories_images';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('categories.id', 'categories.image','category_translations.title','categories.main_category_id','categories.is_active')
            ->join('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', app()->getLocale())
                    ->where('categories.main_category_id', '!=', null);
            })->orderBy('categories.created_at', 'desc');
    }

    public function getMadeInEgyptSubCategories()
    {
        return $this->model->whereHas('subProducts', function ($query) {
            $query->where('made_in_egypt', '=', 'yes')->where("is_active", 1);
        })->where("is_active", 1)->get();
    }

    public function getOffersSubCategories()
    {
        return $this->model->whereHas('subProducts', function ($query) {
            $query->whereHas('offer')->where("is_active", 1);
        })->where("is_active", 1)->get();
    }
    public function getOurProductsSubCategories()
    {
        return $this->model->whereHas('subProducts', function ($query) {
            $query->where('our_products', '=', 'yes')->where("is_active", 1);
        })->where("is_active", 1)->get();
    }
}
