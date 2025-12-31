<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\DriverService as objService;
use Illuminate\Http\Request;

class GetAvailableDriversToExternalOrdersController extends Controller
{
    private string $folderPath = 'banha.available_drivers.';
    public function index(Request $request, objService $service)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'drivers' => $service->getWhere(['status' => DriverStatusEnum::Available->value]),
                    'order_id' => $request->order_id,
                    'storeRoute' => route('choose-driver-to-external-order.store'),
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

}
