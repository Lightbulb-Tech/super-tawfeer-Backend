<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource as objResource;
use App\Services\Banha\FaqService as objService;

class FaqController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->get();
        return jsonSuccess(objResource::collection($data));

    }


}
