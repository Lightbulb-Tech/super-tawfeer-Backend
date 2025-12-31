<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CancelOrderRequest as objRequest;
use App\Services\Banha\OrderService as objService;
use Illuminate\Support\Facades\DB;

class CancelOrderController extends Controller
{
    public function store(objRequest $request, objService $service)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $result = $service->cancelOrderFromUser($data);
            if (isset($result['error'])) {
                return jsonSuccess(null, $result['error'], 422);
            }
            DB::commit();
            return jsonSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonSuccess(null, __("api.a_serve_error_occurred_please_try_again"), 500);
        }
    }
}
