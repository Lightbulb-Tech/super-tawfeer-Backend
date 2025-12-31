<?php

namespace App\Http\Controllers\TamoTech\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Permission\PermissionRequest;
use App\Services\TamoTech\PermissionService;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public $folderPath = "tamotech.permissions";
    public $mainRoute = "permissions";

    public function index(PermissionService $action)
    {
        if (\request()->ajax()) {
            $currencies = $action->getDataTable();
            return DataTables::of($currencies)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $deleteButton = '';
                    $editButton = editBtn($this->mainRoute, $row->id, $row->name);
                    if (auth('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value) {
                        $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    }
                    return $editButton . ' ' . $deleteButton;
                })->rawColumns(['actions'])->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("permission.permissions");
        $data["addButtonText"] = __("auth.permissions");
        $data["mainRoute"] = $this->mainRoute;
        $data["modalType"] = "";
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\request()->ajax()) {
            $returnHTML = view($this->folderPath . ".create")->with([
                'storeRoute' => route($this->mainRoute . ".store"),
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request , PermissionService $action)
    {
        $postData = $request->validated();
        $data = $action->store($postData);
        return jsonSuccess($data);
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
    public function edit(string $id , PermissionService $action)
    {
        if (\request()->ajax()) {
            $returnHTML = view($this->folderPath . ".edit")->with([
                "obj" => $action->find($id),
                'updateRoute' => route($this->mainRoute . ".update", $id),
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id , PermissionService $action)
    {
        $postData = $request->validated();
        $data = $action->update($id, $postData);
        return jsonSuccess($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id , PermissionService $action)
    {
        $action->delete($id);
        return jsonSuccess();
    }
}
