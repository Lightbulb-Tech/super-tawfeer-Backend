<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppSettingsResource as objResource;
use App\Services\Banha\AppSettingsService as objService;
use Illuminate\Support\Facades\Auth;

class AppSettingsController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->first();
        return jsonSuccess(objResource::make($data));
    }
}
