<?php

namespace App\Services\TamoTech;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthService

{
    public function __construct(private AdminService $adminService)
    {

    }

    public function checkAuth($credentials)
    {
        $admin = $this->adminService->getWhereFirst(['email' => $credentials['email']]);
        if (!$admin) {
            return ['error' => __("auth.email_is_incorrect")];
        }
        if (!Hash::check($credentials['password'], $admin->password)) {
            return ['error' => __("auth.password_is_incorrect")];
        }
        if (Auth::guard('admin')->attempt($credentials)) {
            Session::put('status', true);
            return true;
        } else {
            return false;
        }
    }

}
