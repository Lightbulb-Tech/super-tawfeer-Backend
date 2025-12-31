<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource as objResource;
use App\Services\Banha\OrderService as objService;

class OrderController extends Controller
{
    public function show($id, objService $service)
    {
        $data = $service->find($id);
        if (!isset($data)) {
            return jsonSuccess(null, __("api.data_not_found"), 422);
        }
        return jsonSuccess(objResource::make($data));
    }

}
