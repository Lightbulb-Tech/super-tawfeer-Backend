<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\ChooseDriverToOrderRequest;
use App\Services\Banha\DriverService;
use App\Services\Banha\OrderService as objService;

class ChooseDriverToOrderController extends Controller
{
    public function store(ChooseDriverToOrderRequest $request, objService $service, DriverService $driverService)
    {
        $data = $request->validated();
        $order = $service->find($data['order_id']);
        $driver = $driverService->find($data['driver_id']);
        $order->update(['driver_id' => $data['driver_id']]);
        $driver->update(['status' => DriverStatusEnum::NotAvailable->value]);
        return jsonSuccess();
    }

}
