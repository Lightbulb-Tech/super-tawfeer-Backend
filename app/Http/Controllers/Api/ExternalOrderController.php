<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ExternalOrderRequest as objRequest;
use App\Http\Resources\ExternalOrderResource;
use App\Services\Banha\ExternalOrderService as objService;
use Exception;
use Illuminate\Support\Facades\DB;

class ExternalOrderController extends Controller
{
    public function store(objRequest $request, objService $service)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $externalOrder = $service->makeExternalOrder($data);
            DB::commit();
            return jsonSuccess(ExternalOrderResource::make($externalOrder));
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonSuccess(null, $exception->getMessage(), 500);
        }
    }

}
