<?php

namespace App\Http\Controllers\TamoTech\Authentication;

use App\Enums\AdminTypeisEnum;
use App\Http\Controllers\Controller;
use App\Services\TamoTech\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public array $data = ['email', 'password'];

    public function loginPage()
    {
        if (!Auth::guard('admin')->check()) {
            return view('tamotech.auth.login');
        } else {
            return redirect()->back();
        }
    }

    public function checkLogin(Request $request, AuthService $service)
    {
        $credentials = $request->only($this->data);
        $result = $service->checkAuth($credentials);
        if (isset($result['error'])) {
            return jsonSuccess(['messageFail' => $result['error']], $result['error'], 422);
        }
        if (Auth::guard('admin')->user()->admin_type == AdminTypeisEnum::Developer->value) {
            return jsonSuccess(['messageSuccess' => __('auth.toasterLoginSuccessfully'), 'redirect' => route('admins.index')]);
        } else {
            return jsonSuccess(['messageSuccess' => __('auth.toasterLoginSuccessfully'), 'redirect' => route('dashboard.index')]);
        }

    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
