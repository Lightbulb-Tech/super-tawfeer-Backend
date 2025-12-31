<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\CouponActiveRequest as objRequest;
use App\Services\Banha\CouponService as objService;


class CouponActiveController extends Controller
{
    public function update(objRequest $request, string $id, objService $service)
    {
        $dataInsert = $request->validated();
        $obj = $service->find($id);
        $obj->is_active = $dataInsert['is_active'];
        $obj->save();
        return jsonSuccess();

    }

}
