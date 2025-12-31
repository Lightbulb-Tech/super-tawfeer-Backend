<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendCodeRequest;
use App\Services\Banha\PhoneCodeService;

class SendCodeController extends Controller
{
    public function store(SendCodeRequest $request, PhoneCodeService $service)
    {
        $data = $request->validated();
        $service->sendCode($data);
        return jsonSuccess(null ,__("api.code_send_successfully"));
    }

}
