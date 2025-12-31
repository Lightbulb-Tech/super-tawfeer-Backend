<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\ProductService as objService;

class ProductController extends Controller
{
    public function show($id, objService $service)
    {
        $product = $service->find($id);
        if (!$product) {
            return jsonSuccess(null, __('api.data_not_found'), 422);
        }
        $relatedProducts = $service->getWhere(['sub_category_id' => $product->sub_category_id])
            ->where('id', '!=', $product->id)
            ->shuffle()
            ->take(10);
        return jsonSuccess(['product' => objResource::make($product), 'relatedProducts' => objResource::collection($relatedProducts)]);
    }

}
