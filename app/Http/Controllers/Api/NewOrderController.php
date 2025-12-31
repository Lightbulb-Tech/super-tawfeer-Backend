<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource as objResource;
use App\Services\Banha\OrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewOrderController extends Controller
{
    public function index(Request  $request , objService $service)
    {
        $data = $service->getOrders([OrderStatusEnum::Pending->value], Auth::guard('api')->user());
        return generalReturn($request ,$data , objResource::class);
    }

}
