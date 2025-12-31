<?php

namespace App\Http\Controllers\Banha;

use App\Enums\ReservationStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\ReservationService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompleteReservationsController extends Controller
{
    private string $folderPath = 'banha.complete_reservations.';
    private string $mainRoute = 'complete-reservations';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getReservationForDataTable([ReservationStatusEnum::Completed->value]);
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
                ->editColumn('final_price', function ($row) {
                    return '<span class="badge bg-success">' . $row->final_price . '</span>';
                })
                ->editColumn('vehicle', function ($row) {
                    return @$row->vehicle->model;
                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == ReservationStatusEnum::Completed->value) {
                        $result = '<span class="badge bg-success">' . ReservationStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                    return $result;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                    $showButton = showBtn($this->mainRoute, $row->id);

                    return $showButton . ' ' . $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'status', 'final_price'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.complete_reservations");
        $data["addButtonText"] = __("banha.complete_reservations");
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
