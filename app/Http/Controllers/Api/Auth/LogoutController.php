<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Banha\FirebaseTokenService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store(Request $request , FirebaseTokenService $firebaseTokenService)
    {
        $user = auth('api')->user();
        if ($request->firebase_token) {
            $firebaseTokenService->deleteWhere(['user_id' => $user->id, 'token' => $request->firebase_token]);
        }
        auth('api')->logout();
        return jsonSuccess();
    }

}
