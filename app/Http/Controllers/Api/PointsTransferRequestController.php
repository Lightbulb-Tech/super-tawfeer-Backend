<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Banha\PointsTransferRequestService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointsTransferRequestController extends Controller
{
    public function store(Request $request, objService $service)
    {
        DB::beginTransaction();
        try {
            $user = Auth::guard('api')->user();
            $result = $service->pointsTransferRequest($user);
            DB::commit();
            if (isset($result['error'])) {
                return jsonSuccess(null, $result['error'] , 422);
            }
            return jsonSuccess(null, __("api.point_transfer_success_message"));
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonSuccess(null, __("api.a_serve_error_occurred_please_try_again"), 500);
        }
    }
}
