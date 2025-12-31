<?php

namespace App\Http\Controllers\Banha;

use App\Enums\ExternalOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\ExternalOrderService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CancelExternalOrderController extends Controller
{
    private string $folderPath = 'banha.cancel_external_orders.';
    private string $mainRoute = 'cancel-external-orders';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getExternalOrdersForDataTable([ExternalOrderStatusEnum::CanceledFromAdmin->value, ExternalOrderStatusEnum::CanceledFromUser->value]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_name', function ($row) {
                    if (isset($row->user_id)) {
                        return @$row->user->first_name ?? '-' . ' ' . @$row->user->last_name ?? '-';
                    } else {
                        return $row->name;
                    }
                })
                ->editColumn('user_phone', function ($row) {
                    if (isset($row->user_id)) {
                        return @$row->user->phone;
                    } else {
                        return $row->phone;
                    }
                })
                ->editColumn('orders_price', function ($row) {
                    return  $row->orders_price ?? '-' ;
                })
                ->editColumn('final_price', function ($row) {
                    return  $row->final_price ?? '-';
                })
                ->editColumn('area', function ($row) {
                    return @$row->area->title;
                })
                ->editColumn('driver_name', function ($row) {
                    return @$row->driver->name ?? '-';

                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == ExternalOrderStatusEnum::CanceledFromAdmin->value) {
                        $result = '<span class="badge bg-danger">' . ExternalOrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } elseif ($row->status == ExternalOrderStatusEnum::CanceledFromUser->value) {
                        $result = '<span class="badge bg-danger">' . ExternalOrderStatusEnum::tryFrom($row->status)->lang() . '</span>';

                    }
                    return $result;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                    $showButton = showBtn($this->mainRoute, $row->id);
                    return $showButton . ' ' . $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'status', 'final_price', 'orders_price', 'driver_name'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.cancel_external_orders");
        $data["addButtonText"] = __("banha.cancel_external_orders");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    public function show(string $id, objService $service)
    {
        $html = view($this->folderPath . 'show')
            ->with([
                'obj' => $service->find($id),
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }
}
