<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Enums\VehicleStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\VehicleRequest as objRequest;
use App\Services\Banha\VehicleService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    private string $folderPath = 'banha.vehicles.';
    private string $mainRoute = 'vehicles';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == DriverStatusEnum::Available->value){
                        return '<span class="badge bg-success">'. VehicleStatusEnum::tryFrom($row->status)->lang().'</span>';
                    } else{
                        return '<span class="badge bg-danger">' . VehicleStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                })
                ->editColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" class="toggle-switch" data-id="' . $row->id . '" data-field="is_active" ' . $checked . '>
                                <span class="slider round"></span>
                            </label>';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions','image','is_active','status'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.vehicles");
        $data["addButtonText"] = __("banha.vehicles");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objService $service)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->storeWithFiles($dataInsert);
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
    public function edit($id, objService $service)
    {
        $html = view($this->folderPath . 'edit')
            ->with([
                'updateRoute' => route($this->mainRoute . '.update', $id),
                'obj' => $service->find($id),
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, string $id, objService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->updateWithFiles($id, $dataInsert);
        return jsonSuccess($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, objService $service)
    {
        $service->deleteWithFiles($id);
        return jsonSuccess();

    }
}
