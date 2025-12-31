<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PointHistoryResource as objResource;
use App\Services\Banha\PointHistoryService as objService;
use Illuminate\Support\Facades\Auth;

class PointHistoriesController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['user_id' => Auth::guard('api')->user()->id]);
        return jsonSuccess(objResource::collection($data));
    }

}
