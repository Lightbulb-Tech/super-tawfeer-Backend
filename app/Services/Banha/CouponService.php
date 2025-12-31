<?php

namespace App\Services\Banha;

use App\Repositories\Banha\CouponRepository;

class CouponService
{
    public function __construct(private CouponRepository $repository)
    {

    }
    public function getDataTable()
    {
        return $this->repository->getDataTable();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function first()
    {
        return $this->repository->first();
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function storeWithFiles($data)
    {
        return $this->repository->storeWithFiles($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }


    public function updateWithFiles($id, $data)
    {
        return $this->repository->updateWithFiles($id, $data);

    }

    public function deleteWithFiles($id): bool
    {
        return $this->repository->deleteWithFiles($id);

    }

    public function get()
    {
        return $this->repository->get();
    }

    public function getWhere($where)
    {
        return $this->repository->getWhere($where)->get();
    }

    public function getWhereFirst($where)
    {
        return $this->repository->getWhereFirst($where);
    }

    public function checkCoupon($coupon)
    {
        if (!$this->checkCouponIsActive($coupon)) {
            return ['error' => __("api.this_coupon_is_not_active")];
        } elseif (!$this->checkCouponDateValid($coupon)) {
            return ['error' => __("api.this_coupon_is_expire")];
        } elseif (!$this->checkCouponUsedTimes($coupon)) {
            return ['error' => __("api.this_coupon_has_reached_its_maximum_usage_limit")];
        } else {
            return $coupon;
        }
    }

    public function checkCouponIsActive($coupon): bool
    {
        return $coupon->is_active == 1;
    }

    public function checkCouponDateValid($coupon): bool
    {
        $currentDate = now()->format('Y-m-d');
        return $coupon->from_date <= $currentDate && $coupon->to_date > $currentDate;
    }

    public function checkCouponUsedTimes($coupon): bool
    {
        return $coupon->already_used < $coupon->usage_times;
    }

}
