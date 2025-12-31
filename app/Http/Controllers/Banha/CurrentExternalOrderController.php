<?php

namespace App\Http\Controllers\Banha;

use App\Enums\ExternalOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\ExternalOrderService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CurrentExternalOrderController extends Controller
{
    private string $folderPath = 'banha.current_external_orders.';
    private string $mainRoute = 'current-external-orders';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getExternalOrdersForDataTable([ExternalOrderStatusEnum::Confirmed->value, ExternalOrderStatusEnum::InProgress->value, ExternalOrderStatusEnum::OnTheWay->value]);
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
                    if (isset($row->orders_price) && $row->orders_price != null) {
                        return '<span class="badge bg-success">' . $row->orders_price . '</span>';
                    } else {
                        return '<button class="btn btn-danger register_final_price mb-2"  data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.register_final_price') . '
                            </button>';
                    }
                })
                ->editColumn('final_price', function ($row) {
                    return '<span class="badge bg-success">' . $row->final_price . '</span>';
                })
                ->editColumn('area', function ($row) {
                    return @$row->area->title;
                })
                ->editColumn('driver_name', function ($row) {
                    if (isset($row->driver) && $row->driver_id != null) {
                        return @$row->driver->name ?? '-';
                    } else {
                        return '<button class="btn btn-dark choose_driver mb-2"  data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.choose_driver') . '
                            </button>';
                    }
                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == ExternalOrderStatusEnum::Confirmed->value) {
                        $result = '<span class="badge bg-warning">' . ExternalOrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == ExternalOrderStatusEnum::InProgress->value) {
                        $result = '<span class="badge bg-success">' . ExternalOrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == ExternalOrderStatusEnum::OnTheWay->value) {
                        $result = '<span class="badge bg-success">' . ExternalOrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                    return $result;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                    $nextStatusButton = '';
                    $showButton = showBtn($this->mainRoute, $row->id);
                    if ($row->status == ExternalOrderStatusEnum::Confirmed->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . ExternalOrderStatusEnum::InProgress->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.start_preparing') . '
                            </button>';
                    } elseif ($row->status == ExternalOrderStatusEnum::InProgress->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . ExternalOrderStatusEnum::OnTheWay->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.start_delivered') . '
                            </button>';
                    } elseif ($row->status == ExternalOrderStatusEnum::OnTheWay->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . ExternalOrderStatusEnum::Delivered->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.delivered_to_client') . '
                            </button>';
                    }
                    return $nextStatusButton . ' ' . $showButton . ' ' . $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'status', 'final_price', 'orders_price', 'driver_name'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.current_external_orders");
        $data["addButtonText"] = __("banha.current_external_orders");
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
