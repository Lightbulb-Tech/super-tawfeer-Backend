<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

class MainRepository
{
    protected $model;
    protected $fileFolder;
    protected $columsFile;


    public function clearRequesrt($data)
    {
        foreach ($data as $key => $value) {
            $trimedValue = (gettype($value) == "string") ? trim($value) : $value;
            if (empty($trimedValue)) {
                unset($data[$key]);
                continue;
            }
            $data[$key] = $trimedValue;
        }
        return $data;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function store($data)
    {
        $data = $this->clearRequesrt($data);
        return $this->model->create($data);
    }

    public function storeWithFiles($data, array $columns = null, $file_folder = null)
    {
        $columns = $this->columsFile;
        $file_folder = $this->fileFolder;
        if (isset($data)) {
            foreach ($data as $key => $value) {
                if (in_array($key, $columns)) {
                    $data[$key] = upload_image($data[$key], $file_folder);
                }
            }
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            return $this->store($data);
        }
    }

    public function storeWithFilesWithOneLanguage($data, array $columns = null, $file_folder = null)
    {
        $columns = $this->columsFile;
        $file_folder = $this->fileFolder;
        if (isset($data)) {
            foreach ($data as $key => $value) {
                if (in_array($key, $columns)) {
                    $data[$key] = upload_image($data[$key], $file_folder);
                }
            }
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            foreach ($data['ar'] as $field => $value) {
                if (empty($data['en'][$field])) {
                    $data['en'][$field] = $value;
                }
            }
            return $this->store($data);
        }
    }

    public function update($id, $data)
    {
        $data = $this->clearRequesrt($data);
        return $this->model->find($id)->update($data);
    }


    public function updateWithFiles($id, $data, array $columns = null, $file_folder = null)
    {
        $file_folder = $this->fileFolder;
        $columns = $this->columsFile;
        $obj = $this->find($id);
        if (isset($data) && $obj) {
            foreach ($data as $key => $value) {
                if (in_array($key, $columns)) {
                    delete_image($obj->$key);
                    $data[$key] = upload_image($data[$key], $file_folder);
                }
            }
            return $this->update($id, $data);
        }
    }

    public function deleteWithFiles($id, array $columns = null)
    {
        $columns = $this->columsFile;
        $obj = $this->find($id);
        if (isset($obj)) {
            foreach ($columns as $column) {
                delete_image($obj->$column);
            }
            $this->delete($id);
        }
        return true;
    }

    public function get()
    {
        return $this->model->get();
    }

    public function getWhere($where)
    {
        return $this->model->where($where)->get();
    }
    public function where($where)
    {
        return $this->model->where($where);
    }

    public function getWhereWithoutGet($where)
    {
        return $this->model->where($where)->latest('id');
    }

    public function getWhereWithPagination($where)
    {
        return $this->model->where($where)->latest();
    }
    public function getWhereFirst($where)
    {
        return $this->model->where($where)->first();
    }

    public function getWhereIn($column,$where)
    {
        return $this->model->whereIn($column,$where)->get();
    }

    public function getWhereInWithPagination($column, $where)
    {
        return $this->model->whereIn($column, $where);
    }

    public function lastId()
    {
        $row = $this->model->orderBy('id', 'DESC')->first();
        return (isset($row->id)) ? ($row->id + 1) : 1;
    }


    public function deleteWithFile($id, $column)
    {
        $obj = $this->find($id);
        delete_image($obj->{$column});
        $this->delete($id);
    }

    public function updateWhere($where, $data)
    {
        return $this->model->where($where)->update($data);
    }

    public function findToArray($id)
    {
        return $this->model->find($id)->toArray();
    }

    public function deleteWhere($where)
    {
        return $this->model->where($where)->delete();
    }


    public function UpdateOrStore($where,$data){
        $data["created_by_id"] = auth('admin')->user()->id;
        return $this->model->updateOrCreate($where,$data);
    }

    public function getDataTable()
    {
        return $this->model->query()->latest();
    }

}
