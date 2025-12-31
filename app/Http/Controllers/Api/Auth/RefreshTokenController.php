<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Banha\UserService;

class RefreshTokenController extends Controller
{
    public function store(UserService $service)
    {
        $token = 'Bearer ' . $service->refreshToken();
        return jsonSuccess($token);
    }
}
