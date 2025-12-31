<?php

namespace App\Http\Controllers\Banha;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\FaqRequest as objRequest;
use App\Services\Banha\OrderService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CurrentOrderController extends Controller
{
    private string $folderPath = 'banha.current_orders.';
    private string $mainRoute = 'current-orders';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getOrdersForDataTable([OrderStatusEnum::Confirmed->value, OrderStatusEnum::InProgress->value, OrderStatusEnum::OnTheWay->value]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_name', function ($row) {
                    return @$row->user->first_name ?? '-' . ' ' . @$row->user->first_name ?? '-';
                })
                ->editColumn('driver_name', function ($row) {
                    if (isset($row->driver) && $row->driver_id != null) {
                        return @$row->driver->name ?? '-';
                    } else {
                        return '<button class="btn btn-dark choose_driver mb-2"  data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.choose_driver') . '
                            </button>';
                    }
                })
                ->editColumn('user_phone', function ($row) {
                    return @$row->user->phone;
                })
                ->editColumn('payment_type', function ($row) {
                    return '<span class="badge bg-danger">' . PaymentTypesEnum::tryFrom($row->payment_type)->lang() . '</span>';
                })
                ->editColumn('final_price', function ($row) {
                    return '<span class="badge bg-success">' . $row->final_price . '</span>';
                })
                ->editColumn('total_points', function ($row) {
                    return '<span class="badge bg-dark">' . $row->total_points . '</span>';
                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == OrderStatusEnum::Confirmed->value) {
                        $result = '<span class="badge bg-warning">' . OrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == OrderStatusEnum::InProgress->value) {
                        $result = '<span class="badge bg-success">' . OrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == OrderStatusEnum::OnTheWay->value) {
                        $result = '<span class="badge bg-success">' . OrderStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                    return $result;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $cancelButton = '';
                    $deleteButton = '';
                    $nextStatusButton = '';
                    $exportInvoiceButton = '';
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
//                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    if (checkIfHasPermission('invoices-create')) {
                        $exportInvoiceButton = '<a  target="_blank" href="' . route('invoices.show', $row->id) . '"><button type="button" class="btn btn-dark  mb-2" > <i class="fa fa-file-invoice"></i> </button></a>';
                    }
                    $showButton = showBtn($this->mainRoute, $row->id);
                    $cancelButton = '<button type="button" class="btn btn-warning  mb-2 change_order_status" data-status="' . OrderStatusEnum::CanceledFromAdmin->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '"> ' . __('banha.cancel_order') . '
                                     </button>';
                    if ($row->status == OrderStatusEnum::Confirmed->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . OrderStatusEnum::InProgress->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.start_preparing') . '
                            </button>';
                    } elseif ($row->status == OrderStatusEnum::InProgress->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . OrderStatusEnum::OnTheWay->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.start_delivered') . '
                            </button>';
                    } elseif ($row->status == OrderStatusEnum::OnTheWay->value) {
                        $nextStatusButton = ' <button class="btn btn-danger change_order_status mb-2" data-status="' . OrderStatusEnum::Delivered->value . '" data-id="' . $row->id . '" data-order-id="' . @$row->id . '">' . __('banha.delivered_to_client') . '
                            </button>';
                    }
                    return $exportInvoiceButton . ' ' . $nextStatusButton . ' ' . $showButton . ' ' . $editButton . ' ' . $deleteButton . ' ' . $cancelButton;
                })
                ->rawColumns(['actions', 'status', 'final_price', 'driver_name', 'total_points', 'payment_type'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.current_orders");
        $data["addButtonText"] = __("banha.current_orders");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objService $service)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->storeWithFilesWithOneLanguage($dataInsert);
        return jsonSuccess($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, objService $service)
    {
        $html = view($this->folderPath . 'show')
            ->with([
                'obj' => $service->find($id),
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, objService $service)
    {
        $html = view($this->folderPath . 'edit')
            ->with([
                'updateRoute' => route($this->mainRoute . '.update', $id),
                'obj' => $service->find($id),
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, string $id, objService $service)
    {
        $dataInsert = $request->validated();
        $data = $service->updateWithFiles($id, $dataInsert);
        return jsonSuccess($data);

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
