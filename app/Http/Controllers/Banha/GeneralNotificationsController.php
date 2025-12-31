<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\GeneralNotificationRequest;
use App\Services\Banha\NotificationService as objService;
use App\Services\Banha\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GeneralNotificationsController extends Controller
{
    private string $folderPath = 'banha.general_notification.';
    private string $mainRoute = 'general-notifications';

    public function index(Request $request, UserService $userService)
    {
        $data["users"] = $userService->getWhere(['is_blocked' => 0]);
        $data["storeRoute"] = route($this->mainRoute . ".store");
        $data["bladeTitle"] = __("banha.general_notifications");
        return view($this->folderPath . '.index', $data);
    }

    public function store(GeneralNotificationRequest $request, objService $service)
    {
        $dataInsert = $request->validated();
        $admin_id = Auth::guard('admin')->id();
        $data = $service->storeGeneralNotification($dataInsert, $admin_id);
        return jsonSuccess($data, null, 201);
    }

}
