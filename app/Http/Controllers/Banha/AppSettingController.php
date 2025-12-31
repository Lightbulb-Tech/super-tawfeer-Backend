<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\AppSettingsRequest;
use App\Services\Banha\AppSettingsService;

class AppSettingController extends Controller
{
    public string $folderPath = 'banha.app_settings.';
    private string $mainRoute = 'app-settings';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appSetting = null;
        if (app('app-settings') !== null) {
            $appSetting = app('app-settings')->first();
            $data['updateRoute'] = route($this->mainRoute . '.update', $appSetting->id);
        }
        $data['storeRoute'] = route($this->mainRoute . '.store');
        return view($this->folderPath . 'index', $data, compact('appSetting'));
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
    public function store(AppSettingsRequest $request, AppSettingsService $service)
    {
        $dataInsert = $request->validated();
        $service->storeWithFiles($dataInsert);
        return jsonSuccess(null, null, 201);
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
    public function update(AppSettingsRequest $request, $id, AppSettingsService $service)
    {
        $dataInsert = $request->validated();
        $service->updateWithFiles($id, $dataInsert);
        return jsonSuccess(null, null, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
