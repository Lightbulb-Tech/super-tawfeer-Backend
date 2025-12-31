<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\Banha\UserService;

class UserController extends Controller
{
    public function show($id, UserService $service)
    {
        $user = $service->find($id);
        if (!$user) {
            return jsonSuccess(null, __("api.data_not_found"));
        }
        return jsonSuccess(UserResource::make($user));
    }

    public function update(UserRequest $request, $id, UserService $service)
    {
        $data = $request->validated();
        $user = $service->find($id);
        if (!$user) {
            return jsonSuccess(null, __("api.data_not_found"));
        }
        $service->updateWithFiles($id, $data);
        $user = $service->find($id);
        return jsonSuccess(UserResource::make($user));
    }

}
