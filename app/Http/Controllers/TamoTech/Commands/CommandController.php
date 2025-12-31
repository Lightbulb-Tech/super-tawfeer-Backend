<?php

namespace App\Http\Controllers\TamoTech\Commands;

use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Command\CommandRequest as objRequest;
use App\Services\TamoTech\CommandService as objService;
use Yajra\DataTables\Facades\DataTables;

class CommandController extends Controller
{
    private string $folderPath = 'tamotech.commands.';
    private string $mainRoute = 'commands';

    public function index(objService $service)
    {
        if (\request()->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->command);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("main.commands");
        $data["addButtonText"] = __("main.command");
        $data["modelSize"] = '';
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
        $data = $service->store($dataInsert);
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
        $data = $service->update($id, $dataInsert);
        return jsonSuccess($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, objService $service)
    {
        $service->delete($id);
        return jsonSuccess();

    }
}
