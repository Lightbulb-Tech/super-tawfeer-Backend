<?php

namespace App\Services\TamoTech;

use App\Enums\AdminTypeisEnum;
use App\Models\TamoTech\Admin;
use App\Services\MainService;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;

class AdminService extends MainService
{
    use ImageTrait;

    public function __construct(Admin $model, private RoleService $roleAction)
    {
        $this->model = $model;
        $this->fileFolder = 'adminsImages';
        $this->columsFile = ['image'];
    }

    public function getAuthUser()
    {
        $user = Auth::guard('admin')->user();
        return $user;
    }

    public function storeAdmin($data)
    {
        $data["admin_type"] = AdminTypeisEnum::SuperAdmin->value;
        $admin = $this->storeWithFiles($data, $this->columsFile, $this->fileFolder);
        $admin->syncRoles([$data['role_id']]);
        return $admin;
    }

    public function updateAdmin($id, $data)
    {
        $admin = $this->model->find($id);
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $this->updateWithFiles($id, $data, $this->columsFile, $this->fileFolder);
        $role = $this->roleAction->find($data['role_id']);
        $admin->syncRoles([$role->id]);
        return $admin;
    }

    public function getRoles()
    {
        return $this->roleAction->get();
    }
    public function getAdmin($id)
    {
        return $this->model->where("id", "!=", $id)->first();
    }

}
