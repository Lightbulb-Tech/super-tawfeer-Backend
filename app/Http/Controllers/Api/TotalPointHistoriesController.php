<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Banha\PointHistoryService as objService;
use Illuminate\Support\Facades\Auth;

class TotalPointHistoriesController extends Controller
{
    public function index(objService $service)
    {
        $user = Auth::guard('api')->user();
        $appSettings = app('app-settings')->first();
        $pointPrice = $appSettings->point_price ?? 0.0;
        return jsonSuccess(['total_points' => $user->points, 'total_price' => $user->points * $pointPrice]);
    }

}
