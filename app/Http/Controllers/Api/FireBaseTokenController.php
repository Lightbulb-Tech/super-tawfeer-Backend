<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FirebaseTokenRequest as objRequest;
use App\Services\Banha\FirebaseTokenService as objService;

class FireBaseTokenController extends Controller
{
    public function store(objRequest $request, objService $service)
    {
        $user = auth('api')->user();
        $dataInsert = $request->validated();
        $service->storeToken($user->id, $dataInsert);
        return jsonSuccess();
    }

}
