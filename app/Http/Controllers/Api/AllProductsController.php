<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\MainCategoryService;
use App\Services\Banha\ProductService as objService;
use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    public function index(Request $request, objService $service, MainCategoryService $mainCategoryService)
    {
        if (isset($request->main_category_id) && $request->filled('main_category_id')) {
            $mainCategory = $mainCategoryService->find($request->main_category_id);
            if (isset($mainCategory)) {
                $sub_category_id = isset($request->sub_category_id) ? $request->sub_category_id : null;
                $data = $service->getAllProductsForMainCategory($request->main_category_id, $sub_category_id);
                return generalReturn($request, $data, objResource::class);
            }
        } else {
            return jsonSuccess(null, __("api.data_not_found") ,422);
        }
    }

}
