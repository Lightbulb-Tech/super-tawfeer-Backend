<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Banha\CartService as objService;
use Illuminate\Support\Facades\Auth;

class CartCountController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['user_id' => Auth::guard('api')->id()])->count();
        return jsonSuccess($data);
    }

}
