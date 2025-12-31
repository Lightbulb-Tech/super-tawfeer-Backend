<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Banha\Product;
use App\Services\Banha\ProductService as objService;
use Illuminate\Support\Facades\DB;

class MostSellingProductsController extends Controller
{
    public function index(objService $service)
    {

        $topProductIds = DB::table('order_details')
            ->select('product_id')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(product_id) DESC')
            ->take(15)
            ->pluck('product_id');

        $bestSellingProducts = Product::whereIn('id', $topProductIds)
            ->with('mainCategory', 'subCategory')
            ->get();
        return jsonSuccess(ProductResource::collection($bestSellingProducts));
    }

}
