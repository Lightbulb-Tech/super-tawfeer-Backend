<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\MainCategoryActiveRequest as objRequest;
use App\Services\Banha\MainCategoryService as objService;


class MainCategoryActiveController extends Controller
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
