<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\ChooseDriverToOrderExternalRequest;
use App\Services\Banha\DriverService;
use App\Services\Banha\ExternalOrderService as objService;

class ChooseDriverToExternalOrderController extends Controller
{
    public function store(ChooseDriverToOrderExternalRequest $request, objService $service, DriverService $driverService)
    {
        $data = $request->validated();
        $external_order = $service->find($data['order_id']);
        $driver = $driverService->find($data['driver_id']);
        $external_order->update(['driver_id' => $data['driver_id']]);
        $driver->update(['status' => DriverStatusEnum::NotAvailable->value]);
        return jsonSuccess();
    }

}
