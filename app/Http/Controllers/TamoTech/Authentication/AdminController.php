<?php

namespace App\Http\Controllers\TamoTech\Authentication;

use App\Enums\AdminTypeisEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Admin\AdminRequest as objRequest;
use App\Services\TamoTech\AdminService as objAdminAction;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    private array $files = ['image'];
    private string $folderPath = 'tamotech.admins.';
    private string $mainRoute = 'admins';

    public function index(objAdminAction $adminAction)
    {
        if (\request()->ajax()) {
            $admins = $adminAction->getDataTable()->where("admin_type", '!=', AdminTypeisEnum::Developer->value);
            return DataTables::of($admins)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->addColumn('actions', function ($row) {
                    if ($row->admin_type ==AdminTypeisEnum::SuperAdmin->value) {
                        return editBtn($this->mainRoute, $row->id, $row->name);
                    } else {
                        return editBtn($this->mainRoute, $row->id, $row->name) . ' ' . deleteBtn($this->mainRoute, $row->id);
                    }
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["mainRoute"] = route($this->mainRoute . ".index");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = helperTrans($this->folderPath);
        $data["addButtonText"] = __("main.admin");
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objAdminAction $action)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                    'roles' => $action->getRoles(),

                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objAdminAction $adminAction)
    {
        $dataInsert = $request->validated();
        $data = $adminAction->storeAdmin($dataInsert);
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
    public function edit($id, objAdminAction $adminAction)
    {
        $html = view($this->folderPath . 'edit')
            ->with([
                'roles' => $adminAction->getRoles(),
                'updateRoute' => route($this->mainRoute . '.update', $id),
                'obj' => $adminAction->find($id),
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, string $id, objAdminAction $adminAction)
    {
        $dataInsert = $request->validated();
        $data = $adminAction->updateAdmin($id, $dataInsert);
        return jsonSuccess();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, objAdminAction $adminAction)
    {
        $adminAction->deleteWithFiles($id, $this->files);
        return jsonSuccess();

    }
}
