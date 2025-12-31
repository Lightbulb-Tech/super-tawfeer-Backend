<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReservationRequest as objRequest;
use App\Http\Resources\ReservationResource;
use App\Services\Banha\ReservationService as objService;
use Exception;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store(objRequest $request, objService $service)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $reservation = $service->makeReservation($data);
            DB::commit();
            return jsonSuccess(ReservationResource::make($reservation));
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonSuccess(null, $exception->getMessage(), 500);
        }
    }

}
