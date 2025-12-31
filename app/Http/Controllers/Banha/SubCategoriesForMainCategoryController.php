<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Services\Banha\SubCategoryService as objService;
use Illuminate\Http\Request;


class SubCategoriesForMainCategoryController extends Controller
{
    private string $folderPath = 'banha.products.render.';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax() && isset($request->main_category_id)) {
            $subCategories = $service->getWhere(['main_category_id' => $request->main_category_id]);
            $html = view($this->folderPath . 'sub_categories')->with(['sub_categories' => $subCategories])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

}
