<?php

namespace App\Http\Controllers\Api;

use App\Enums\ReservationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource as objResource;
use App\Services\Banha\ReservationService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteReservationController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $data = $service->getReservationForApi([ReservationStatusEnum::Completed->value], Auth::guard('api')->user() ?? null);
        return generalReturn($request, $data, objResource::class);
    }

}
