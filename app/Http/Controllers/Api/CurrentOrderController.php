<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Banha\OrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrentOrderController extends Controller
{
    public function index(Request $request  ,objService $service)
    {
        $data = $service->getOrders([OrderStatusEnum::Confirmed->value, OrderStatusEnum::InProgress->value, OrderStatusEnum::OnTheWay->value], Auth::guard('api')->user());
        return generalReturn($request ,$data , OrderResource::class);
    }

}
