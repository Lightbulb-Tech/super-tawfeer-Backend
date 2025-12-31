<?php

namespace App\Http\Controllers\Api;

use App\Enums\VehicleStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource as objResource;
use App\Services\Banha\VehicleService as objService;

class VehicleController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['is_active' => 1, 'status' => VehicleStatusEnum::Available->value]);
        return jsonSuccess(objResource::collection($data));
    }

}
