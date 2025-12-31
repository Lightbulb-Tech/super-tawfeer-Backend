<?php

namespace App\Services\Banha;

use App\Enums\DriverStatusEnum;
use App\Enums\ExternalOrderStatusEnum;
use App\Enums\NotificationTypesEnum;
use App\Repositories\Banha\AreaRepository;
use App\Repositories\Banha\DriverRepository;
use App\Repositories\Banha\ExternalOrderDetailsRepository;
use App\Repositories\Banha\ExternalOrderRepository;
use App\Repositories\Banha\NotificationRepository;
use App\Traits\Firebase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternalOrderDetailService
{
    use Firebase;

    public function __construct(private ExternalOrderDetailsRepository $repository)
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

    public function storeWithFilesWithOneLanguage($data)
    {
        return $this->repository->storeWithFilesWithOneLanguage($data);
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
        return $this->repository->getWhere($where);
    }
}
