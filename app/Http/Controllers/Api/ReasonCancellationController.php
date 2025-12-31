<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReasonCancellationResource as objResource;
use App\Services\Banha\ReasonCancellationService as objService;

class ReasonCancellationController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->get();
        return jsonSuccess(objResource::collection($data));
    }

}
