<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCategoryResource as objResource;
use App\Services\Banha\OrderCategoryService as objService;

class OrderCategoryController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['is_active' => 1]);
        return jsonSuccess(objResource::collection($data));
    }

}
