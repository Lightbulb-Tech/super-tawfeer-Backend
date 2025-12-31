<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MakeOrderRequest as objRequest;
use App\Http\Resources\OrderResource;
use App\Services\Banha\OrderService as objService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MakeOrderController extends Controller
{

    public function store(objRequest $request, objService $service)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::guard('api')->id();
            $order = $service->makeOrder($data);
            DB::commit();
            if (isset($order['error'])) {
                return jsonSuccess(null, $order['error'], 422);
            }
            return jsonSuccess(OrderResource::make($order));
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonSuccess(null, __("api.a_serve_error_occurred_please_try_again"), 500);
        }

    }

}
