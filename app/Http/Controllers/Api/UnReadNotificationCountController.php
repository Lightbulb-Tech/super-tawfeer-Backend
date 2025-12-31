<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Banha\NotificationService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnReadNotificationCountController extends Controller
{
    public function index(Request $request, objService $service)
    {
        $data = $service->getWhere(['to_user_id' => Auth::guard('api')->user()->id, 'is_read' => 0]);
        return jsonSuccess($data->count());
    }

}
