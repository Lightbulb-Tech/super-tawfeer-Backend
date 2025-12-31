<?php

namespace App\Http\Controllers\TamoTech\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Permission\RoleRequest;
use App\Services\TamoTech\RoleService;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    private string $folderPath = 'tamotech.roles.';
    private string $mainRoute = 'roles';

    public function index(RoleService $roleAction)
    {

        if (\request()->ajax()) {
            $roles = $roleAction->getDataTable();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editButton = checkIfHasPermission($this->mainRoute . '-update') ?
                        ' <a href="' . route($this->mainRoute . '.edit', $row->id) . '"><button type="button" class="btn btn-warning">
                               <i class="fa fa-edit"></i>
                          </button></a>
                        ' : '';
                    $deleteButton = checkIfHasPermission($this->mainRoute . '-delete') ? deleteBtn($this->mainRoute, $row->id) : ' ';

                    return $editButton . ' ' . $deleteButton;
                })
                ->escapeColumns([])->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["mainRoute"] = route($this->mainRoute . ".index");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("permission.roles");
        $data["addButtonText"] = __("main.role");
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoleService $roleAction)
    {
        $data["storeRoute"] = $this->mainRoute . '.store';
        $data["permissions"] = $roleAction->getPermissions();
        $data["bladeTitle"] = __("permission.add role");
        return view($this->folderPath . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request, RoleService $action)
    {
        $action->storeRole($request->validated());
        return jsonSuccess(['url' => route($this->mainRoute . '.index')], null, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, RoleService $action)
    {
        $data['role'] = $action->find($id);
        $data['rolePermissions'] = $action->getRolePermissions($id);
        $data["permissions"] = $action->getPermissions();
        $data["bladeTitle"] = __("permission.edit role");
        return view($this->folderPath . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id, RoleService $action)
    {
        $action->updateRole($id, $request->validated());
        return jsonSuccess(['url' => route($this->mainRoute . '.index')],null, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, RoleService $roleAction)
    {
        $roleAction->delete($id);
        return jsonSuccess();
    }
}
