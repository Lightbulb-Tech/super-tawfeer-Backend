<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletHistoryResource as objResource;
use App\Services\Banha\WalletHistoryService as objService;
use Illuminate\Support\Facades\Auth;

class WalletHistoriesController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['user_id' => Auth::guard('api')->user()->id]);
        return jsonSuccess(objResource::collection($data));
    }

}
