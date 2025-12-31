<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Services\Banha\ExternalOrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateExternalOrderStatusController extends Controller
{
    public function update(Request $request, string $id, objService $service)
    {
        DB::beginTransaction();
        try {
            $status = $request->status;
            $reservation = $service->find($id);
            $result =  $service->updateExternalOrderStatus($reservation, $status);
            DB::commit();
            if (isset($result['error'])) {
                return jsonSuccess(null, $result['error'], 422);
            }
            return jsonSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonSuccess(null, __("api.a_serve_error_occurred_please_try_again"), 500);
        }

    }
}
