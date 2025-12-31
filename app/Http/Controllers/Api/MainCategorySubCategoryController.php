<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryResource as objResource;
use App\Services\Banha\SubCategoryService as objService;
use Illuminate\Http\Request;

class MainCategorySubCategoryController extends Controller
{
    public function index(Request $request, objService $service)
    {
        if (isset($request->main_category_id) && $request->filled('main_category_id')) {
            $mainCategory = $service->find($request->main_category_id);
            if (isset($mainCategory)) {
                $data = $service->getWhere(['main_category_id' => $request->main_category_id]);
                return jsonSuccess(objResource::collection($data));
            } else {
                return jsonSuccess(null, __("api.data_not_found"),422);
            }
        }
    }

}
