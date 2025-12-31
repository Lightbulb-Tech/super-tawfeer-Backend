<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryResource as objResource;
use App\Services\Banha\SubCategoryService as objService;

class OffersSubCategoryController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getOffersSubCategories();
        return jsonSuccess(objResource::collection($data));
    }

}
