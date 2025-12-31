<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource as objResource;
use App\Services\Banha\AreaService as objService;

class GovernorateController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getGovernorates();
        return jsonSuccess(objResource::collection($data));
    }

}
