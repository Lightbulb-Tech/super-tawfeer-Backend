<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource as objResource;
use App\Services\Banha\SliderService as objService;

class SliderController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->get();
        return jsonSuccess(objResource::collection($data));
    }


}
