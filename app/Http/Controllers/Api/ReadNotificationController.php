<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Banha\NotificationService as objService;
use Illuminate\Support\Facades\Auth;


class ReadNotificationController extends Controller
{
    public function show($id, objService $service)
    {
        $data = $service->getWhereWithoutGet(['to_user_id' => Auth::guard('api')->user()->id]);
        if ($id == 'all') {
            $data->update(['is_read' => 1]);
        } else {
            $obj = $service->find($id);
            if ($obj) {
                $obj->update(['is_read' => 1]);
            } else {
                return jsonSuccess(null, __('api.data_not_found'), 422);
            }
        }
        return jsonSuccess();
    }

}
