<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavouriteRequest as objRequest;
use App\Services\Banha\FavouriteService as objService;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function store(objRequest $request, objService $service)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::guard('api')->id();
        $obj = $service->getWhereFirst(['product_id' => $data['product_id'], 'user_id' => $data['user_id']]);
        if ($obj) {
            $obj->delete();
            return jsonSuccess(null, __("api.removed_from_favorites"));
        } else {
            $service->store($data);
            return jsonSuccess(null, __("api.added_to_favorites"));
        }
    }
}
