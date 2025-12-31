<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressRequest as objRequest;
use App\Http\Resources\AddressResource as objResource;
use App\Services\Banha\AddressService as objService;
use App\Services\Banha\UserService;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->get()->where("user_id", Auth::guard('api')->id());
        return jsonSuccess(objResource::collection($data));
    }

    public function store(objRequest $request, objService $service, UserService $userService)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::guard('api')->id();
        $user = $userService->find($data['user_id']);
        $user->addresses()->update(['selected' => 0]);
        $obj = $service->store($data);
        $userService->update($obj->user_id, ['checked_address' => $obj->id]);
        $service->update($obj->id, ['selected' => 1]);
        $address = $service->find($obj->id);
        return jsonSuccess(objResource::make($address));
    }

    public function destroy($id, objService $service, UserService $userService)
    {
        $obj = $service->find($id);
        if (!$obj) {
            return jsonSuccess(null, __("api.data_not_found"));
        }
        $userService->where(['checked_address' => $id])->update(['checked_address' => null]);
        $service->delete($id);
        return jsonSuccess();
    }


}
