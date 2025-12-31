<?php

namespace App\Services\Banha;

use App\Repositories\Banha\AreaRepository;
use App\Repositories\Banha\GovernorateRepository;
use App\Repositories\Banha\UserRepository;

class UserService
{
    public function __construct(private UserRepository $repository)
    {

    }
    public function refreshToken()
    {
        return auth('api')->refresh();
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
        return $this->repository->getWhere($where);
    }
    public function where($where)
    {
        return $this->repository->where($where);
    }
}
