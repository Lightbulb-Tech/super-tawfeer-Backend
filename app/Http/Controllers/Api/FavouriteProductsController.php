<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource as objResource;
use App\Services\Banha\ProductService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteProductsController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $user = Auth::guard('api')->user();
        $data = $user->favouriteProducts();
        return generalReturn($request, $data, objResource::class);


    }

}
