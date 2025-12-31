<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\VehicleActiveRequest as objRequest;
use App\Services\Banha\VehicleService as objService;


class VehicleActiveController extends Controller
{
    public function update(objRequest $request, string $id, objService $service)
    {
        $dataInsert = $request->validated();
        $obj = $service->find($id);
        $obj->is_active = $dataInsert['is_active'];
        $obj->save();
        return jsonSuccess();

    }

}
