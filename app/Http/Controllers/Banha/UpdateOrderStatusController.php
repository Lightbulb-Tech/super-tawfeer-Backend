<?php

namespace App\Http\Controllers\Banha;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\FaqRequest as objRequest;
use App\Services\Banha\OrderService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateOrderStatusController extends Controller
{
    private string $folderPath = 'banha.canceled_orders.';
    private string $mainRoute = 'canceled-orders';

    public function index(Request $request, objService $service)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objService $service)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objService $service)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, objService $service)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, objService $service)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, objService $service)
    {
        DB::beginTransaction();
        try {
            $status = $request->status;
            $order = $service->find($id);
            if ($status == OrderStatusEnum::Confirmed->value) {
                $result = $service->confirmOrder($order);
            } elseif ($status == OrderStatusEnum::InProgress->value) {
                $result = $service->startPrepareOrder($order);
            } elseif ($status == OrderStatusEnum::OnTheWay->value) {
                $result = $service->deliverOrderToDriver($order);
            } elseif ($status == OrderStatusEnum::Delivered->value) {
                $result = $service->deliverOrderToClient($order);
            } elseif ($status == OrderStatusEnum::CanceledFromAdmin->value) {
                $result = $service->cancelOrderFromAdmin($order);
            }
            DB::commit();
            if (isset($result['error'])) {
                return jsonSuccess(null, $result['error'], 422);
            }
            return jsonSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            return jsonSuccess(null, __("api.a_serve_error_occurred_please_try_again"), 500);
        }


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
