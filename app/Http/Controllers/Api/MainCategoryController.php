<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryResource as objResource;
use App\Services\Banha\MainCategoryService as objService;

class MainCategoryController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getMainCategories()->where('is_active', 1);
        return jsonSuccess(objResource::collection($data));
    }

}
