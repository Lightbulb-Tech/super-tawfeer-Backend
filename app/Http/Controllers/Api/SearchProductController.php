<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\ProductService as objService;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    public function store(Request $request, objService $service)
    {
        $data = $service->searchProduct($request->title);
        return generalReturn($request, $data, objResource::class);
    }

}
