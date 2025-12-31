<?php

namespace App\Repositories\Banha;

use App\Models\Banha\VehicleReservation;
use App\Repositories\MainRepository;

class ReservationRepository extends MainRepository
{
    public function __construct(VehicleReservation $model)
    {
        $this->model = $model;
        $this->columsFile = [''];
        $this->fileFolder = '';
    }

    public function getReservationForDataTable(array $status): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->with(['user', 'vehicle'])
            ->whereIn('status', $status)->latest();
    }

    public function getReservationForApi(array $status, $user): array|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->with(['user', 'vehicle'])
            ->when($user, function ($query) use ($user) {
                $query->where('user_id', '=', $user->id);
            })
            ->whereIn('status', $status)->latest();
    }

}
