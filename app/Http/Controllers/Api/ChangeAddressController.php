<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangeAddressRequest as objRequest;
use App\Services\Banha\AddressService as objService;
use App\Services\Banha\UserService;
use Illuminate\Support\Facades\Auth;

class ChangeAddressController extends Controller
{

    public function store(objRequest $request, objService $service, UserService $userService)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::guard('api')->id();
        $user = $userService->find($data['user_id']);
        $user->addresses()->update(['selected' => 0]);
        $userService->update($data['user_id'], ['checked_address' => $data['address_id']]);
        $service->update($data['address_id'], ['selected' => 1]);
        return jsonSuccess();
    }


}
