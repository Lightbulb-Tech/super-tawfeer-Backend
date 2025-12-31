<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\DriverRequest as objRequest;
use App\Services\Banha\DriverService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    private string $folderPath = 'banha.drivers.';
    private string $mainRoute = 'drivers';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->addColumn('number_of_orders', function ($row) {
                    return '<span class="badge bg-success">'.  $row->completedOrder()->count().'</span>';
                })
                ->addColumn('number_of_external_orders', function ($row) {
                    return '<span class="badge bg-success">'.  $row->completedExternalOrder()->count().'</span>';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == DriverStatusEnum::Available->value){
                        return '<span class="badge bg-success">'. DriverStatusEnum::tryFrom($row->status)->lang().'</span>';
                    } else{
                        return '<span class="badge bg-danger">' . DriverStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $deleteButton = " ";
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    if (!$row->orders()->exists()) {
                        $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    }
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'image','status','number_of_orders','number_of_external_orders'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.drivers");
        $data["addButtonText"] = __("banha.drivers");
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
        $dataInsert['status'] = DriverStatusEnum::Available->value;
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
