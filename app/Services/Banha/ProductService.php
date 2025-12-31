<?php

namespace App\Services\Banha;

use App\Repositories\Banha\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $repository)
    {

    }

    public function getMadeInEgyptProducts($sub_category_id)
    {
        $data = $this->repository->getWhereWithPagination(['made_in_egypt' => 'yes', 'is_active' => 1]);
        if ($sub_category_id) {
            $data->where('sub_category_id', $sub_category_id);
        }
        return $data;
    }

    public function getOurProducts($sub_category_id)
    {
        $data = $this->repository->getWhereWithPagination(['our_products' => 'yes', 'made_in_egypt' => 'yes', 'is_active' => 1]);
        if ($sub_category_id) {
            $data->where('sub_category_id', $sub_category_id);
        }
        return $data;
    }

    public function getOffersProducts($sub_category_id)
    {
        $data = $this->repository->getOffersProducts();
        if ($sub_category_id) {
            $data->where('sub_category_id', $sub_category_id);
        }
        return $data;
    }

    public function getAllProductsForMainCategory($main_category_id, $sub_category_id)
    {
        $data = $this->repository->getWhereWithPagination(['main_category_id' => $main_category_id]);
        if ($sub_category_id) {
            $data->where('sub_category_id', $sub_category_id);
        }
        return $data;
    }

    public function getDataForDataTable()
    {
        return $this->repository->getDataForDataTable();
    }

    public function getDataWithZeroQuantityForDataTable()
    {
        return $this->repository->getDataWithZeroQuantityForDataTable();
    }

    public function getMostProductsSoldForDataTable()
    {
        return $this->repository->getMostProductsSoldForDataTable();
    }

    public function getMostProductsOrderedForDataTable()
    {
        return $this->repository->getMostProductsOrderedForDataTable();
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
    public function storeProduct($data)
    {
        return $this->repository->storeProduct($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }


    public function updateProduct($id, $data)
    {
        return $this->repository->updateProduct($id, $data);

    }
    public function updateWithFiles($id, $data)
    {
        return $this->repository->updateWithFiles($id, $data);

    }

    public function deleteWithFiles($id): bool
    {
        return $this->repository->deleteWithFiles($id);
    }
    public function deleteProduct($id): bool
    {
        return $this->repository->deleteProduct($id);
    }

    public function get()
    {
        return $this->repository->get();
    }

    public function getWhere($where)
    {
        return $this->repository->getWhere($where);
    }
    public function getWhereWithPagination($where)
    {
        return $this->repository->getWhereWithPagination($where);
    }

    public function searchProduct($title)
    {
        return $this->repository->searchProducts($title);

    }

}
