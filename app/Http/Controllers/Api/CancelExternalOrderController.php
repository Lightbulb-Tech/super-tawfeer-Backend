<?php

namespace App\Http\Controllers\Api;

use App\Enums\ExternalOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExternalOrderResource as objResource;
use App\Services\Banha\ExternalOrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancelExternalOrderController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $data = $service->getExternalForApi([ExternalOrderStatusEnum::CanceledFromUser->value, ExternalOrderStatusEnum::CanceledFromAdmin->value], Auth::guard('api')->user() ?? null);
        return generalReturn($request, $data, objResource::class);
    }

}
