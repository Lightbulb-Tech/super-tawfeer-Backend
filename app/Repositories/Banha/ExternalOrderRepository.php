<?php

namespace App\Repositories\Banha;

use App\Models\Banha\ExternalOrder;
use App\Repositories\MainRepository;

class ExternalOrderRepository extends MainRepository
{
    public function __construct(ExternalOrder $model)
    {
        $this->model = $model;
        $this->columsFile = [''];
        $this->fileFolder = '';
    }

    public function getExternalOrdersForDataTable(array $status): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->with(['user', 'area', 'driver'])
            ->whereIn('status', $status)->latest();
    }

    public function getExternalForApi(array $status, $user): array|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->with(['user', 'area', 'driver'])
            ->when($user, function ($query) use ($user) {
                $query->where('user_id', '=', $user->id);
            })
            ->whereIn('status', $status)->latest();
    }

}
