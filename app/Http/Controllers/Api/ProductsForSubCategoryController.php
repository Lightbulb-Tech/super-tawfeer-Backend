<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\ProductService as objService;
use App\Services\Banha\SubCategoryService;
use Illuminate\Http\Request;

class ProductsForSubCategoryController extends Controller
{
    public function index(Request $request, objService $service, SubCategoryService $subCategoryService)
    {
        if (isset($request->sub_category_id) && $request->filled('sub_category_id')) {
            $subCategory = $subCategoryService->find($request->sub_category_id);
            if (isset($subCategory)) {
                $data = $service->getWhereWithPagination(['sub_category_id' => $request->sub_category_id]);
                return generalReturn($request, $data, objResource::class);
            } else {
                return jsonSuccess(null, __("api.data_not_found"),422);
            }
        }
    }

}
