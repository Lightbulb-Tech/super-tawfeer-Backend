<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\RegisterFinalPriceForOrderExternalRequest;
use App\Services\Banha\ExternalOrderDetailService;
use App\Services\Banha\ExternalOrderService as objService;
use Illuminate\Http\Request;

class RegisterFinalPriceToExternalOrderController extends Controller
{
    private string $folderPath = 'banha.register_price_for_external_order.';

    public function index(Request $request, objService $service)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'external_order' => $service->find($request->order_id),
                    'storeRoute' => route('register-final-to-external-order.store'),
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    public function store(RegisterFinalPriceForOrderExternalRequest $request, objService $service, ExternalOrderDetailService $externalOrderDetailService)
    {
        $data = $request->validated();
        $external_order = $service->find($data['order_id']);
        $external_order->update(['orders_price' => $data['orders_price'], 'final_price' => $data['orders_price'] + $external_order->shipping_price]);
        foreach ($external_order->orderDetails as $key => $detail) {
            $detail->update(['price' => $data['prices'][$key]]);
        }
        return jsonSuccess();
    }

}
