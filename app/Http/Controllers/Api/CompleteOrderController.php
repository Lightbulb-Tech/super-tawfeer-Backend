<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Banha\OrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteOrderController extends Controller
{
    public function index(Request $request ,objService $service)
    {
        $data = $service->getOrders([OrderStatusEnum::Delivered->value, OrderStatusEnum::Returned->value, OrderStatusEnum::CanceledFromAdmin->value, OrderStatusEnum::CanceledFromUser->value], Auth::guard('api')->user());
        return generalReturn($request ,$data , OrderResource::class);
    }

}
