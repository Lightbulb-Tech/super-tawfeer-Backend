<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ConfirmCodeRequest;
use App\Http\Resources\UserWithTokenResource;
use App\Services\Banha\PhoneCodeService;

class ConfirmCodeController extends Controller
{
    public function store(ConfirmCodeRequest $request, PhoneCodeService $service)
    {
        $data = $request->validated();
        $result = $service->confirmCode($data);
        if (isset($result['error'])) {
            return jsonSuccess(null, $result['error'] , 422);
        }
        return jsonSuccess(UserWithTokenResource::make($result));
    }

}
