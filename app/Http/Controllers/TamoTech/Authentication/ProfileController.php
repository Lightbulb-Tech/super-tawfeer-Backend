<?php

namespace App\Http\Controllers\TamoTech\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Admin\AdminRequest as objRequest;
use App\Services\TamoTech\AdminService as objService;

class ProfileController extends Controller
{
    private array $files = ['image'];
    private string $folderPath = 'tamotech.auth.';
    private string $mainRoute = 'admins';

    public function index(objService $service)
    {
        $data["admin"] = $service->getAuthUser();
        return view($this->folderPath . '.profile', $data);
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
                    'roles' => $service->getRoles(),

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
        $data = $service->storeAdmin($dataInsert);
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
                'roles' => $service->getRoles(),
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
        $data = $service->updateAdmin($id, $dataInsert);
        return jsonSuccess();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, objService $service)
    {
        $service->deleteWithFiles($id, $this->files);
        return jsonSuccess();

    }
}
