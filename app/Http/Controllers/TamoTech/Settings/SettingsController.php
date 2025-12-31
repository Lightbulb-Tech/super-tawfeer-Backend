<?php

namespace App\Http\Controllers\TamoTech\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\TamoTech\Settings\SettingsRequest as objRequest;
use App\Services\TamoTech\SettingsService;

class SettingsController extends Controller
{
    public string $folderPath = 'tamotech.settings.';
    private string $file_folder = 'settingsImages';
    private string $mainRoute = 'settings';
    private array $columnsFile = ['icon', 'image_login'];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app('settings') !== null) {
            $setting = app('settings')->first();
            $data['updateRoute'] = route($this->mainRoute . '.update', $setting->id);
        }
        $data['storeRoute'] = route($this->mainRoute . '.store');
        return view($this->folderPath . 'index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, SettingsService $service)
    {
        $dataInsert = $request->validated();
        $service->storeWithFiles($dataInsert, $this->columnsFile, $this->file_folder);
        return redirect(route($this->mainRoute . '.index'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, $id, SettingsService $service)
    {
        $dataInsert = $request->validated();
        $service->updateWithFiles($id, $dataInsert, $this->columnsFile, $this->file_folder);
        return redirect(route($this->mainRoute . '.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
