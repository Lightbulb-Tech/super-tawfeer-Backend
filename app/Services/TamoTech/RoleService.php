<?php

namespace App\Services\TamoTech;

use App\Models\Role;
use App\Services\MainService;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class RoleService extends MainService
{
    use ImageTrait;

    public function __construct(Role $model ,private  PermissionService $permissionAction )
    {
        $this->model = $model;
    }
    public function getPermissions()
    {
        return $this->permissionAction->get();
    }

    public function getRolePermissions($id)
    {
        return DB::table("permission_role")->where("permission_role.role_id", $id)
            ->pluck('permission_role.permission_id', 'permission_role.permission_id')
            ->all();
    }

    public function storeRole($data)
    {
        $role = $this->store($data);
        $permissions = $this->permissionAction->getWhereIn('id', $data['permission'] ?? []);
        $role->syncPermissions($permissions);
        return $role;
    }

    public function updateRole($id,$data)
    {
        $role = $this->find($id);
        $role->update($data);
        $permissions = $this->permissionAction->getWhereIn('id', $data['permission'] ?? []);
        $role->syncPermissions($permissions);
        return $role;
    }
}
