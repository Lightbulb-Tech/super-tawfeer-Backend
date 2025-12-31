<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckCouponRequest as objRequest;
use App\Http\Resources\CouponResource;
use App\Services\Banha\CouponService as objService;

class CheckCouponController extends Controller
{

    public function store(objRequest $request, objService $service)
    {
        $data = $request->validated();
        $coupon = $service->getWhereFirst(['code' => $data['code']]);
        $result = $service->checkCoupon($coupon);
        if (isset($result['error'])) {
            return jsonSuccess(null, $result['error'] , 422);
        }
        return jsonSuccess(CouponResource::make($coupon));

    }


}
