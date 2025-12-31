<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource as objResource;
use App\Services\Banha\NotificationService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $data = $service->getWhereWithPagination(['to_user_id' => Auth::guard('api')->user()->id]);
        return generalReturn($request, $data, objResource::class);
    }

    public function destroy($id, objService $service)
    {
        $data = $service->getWhereWithoutGet(['to_user_id' => Auth::guard('api')->user()->id]);
        if ($id == 'all') {
            $data->delete();
        } else {
            $obj = $service->find($id);
            if ($obj) {
                $obj->delete();
            } else {
                return jsonSuccess(null, __('api.data_not_found'), 422);
            }
        }
        return jsonSuccess();
    }

}
