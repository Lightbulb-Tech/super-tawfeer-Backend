<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class MainService
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

    public function storeWithFiles($data, array $columns, $file_folder = null)
    {
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

    public function update($id, $data)
    {
        $data = $this->clearRequesrt($data);
        return $this->model->find($id)->update($data);
    }


    public function updateWithFiles($id, $data, array $columns, $file_folder = null)
    {
        $file_folder = $this->fileFolder;
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

    public function deleteWithFiles($id, array $columns)
    {
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
    public function getWhereFirst($where)
    {
        return $this->model->where($where)->first();
    }

    public function getWhereIn($column,$where)
    {
        return $this->model->whereIn($column,$where)->get();
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
