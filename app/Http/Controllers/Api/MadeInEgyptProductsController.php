<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\ProductService as objService;
use Illuminate\Http\Request;

class MadeInEgyptProductsController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $sub_category_id = isset($request->sub_category_id) ? $request->sub_category_id : null;

        $data = $service->getMadeInEgyptProducts($sub_category_id);
        return generalReturn($request, $data, objResource::class);
    }

}
