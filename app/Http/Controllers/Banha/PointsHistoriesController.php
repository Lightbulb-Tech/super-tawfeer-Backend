<?php

namespace App\Http\Controllers\Banha;

use App\Enums\PointHistoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\PointHistoryService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PointsHistoriesController extends Controller
{
    private string $folderPath = 'banha.points_histories.';
    private string $mainRoute = 'points-histories';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('order_code', function ($row) {
                    return @$row->order->code ?? '-';
                })
                ->editColumn('user', function ($row) {
                    return @$row->user->first_name ?? '-' . ' ' . $row->user->last_name;
                })
                ->editColumn('user_phone', function ($row) {
                    return @$row->user->phone;
                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == PointHistoryStatusEnum::Pending->value) {
                        $result = '<span class="badge bg-warning">' . PointHistoryStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == PointHistoryStatusEnum::Success->value) {
                        $result = '<span class="badge bg-success">' . PointHistoryStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == PointHistoryStatusEnum::Failed->value) {
                        $result = '<span class="badge bg-danger">' . PointHistoryStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                    return $result;
                })
                ->editColumn('points', function ($row) {
                    return $row->points;
                })
                ->editColumn('price', function ($row) {
                    return $row->price;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'user', 'status', 'total', 'point_price'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.points_histories");
        $data["addButtonText"] = __("banha.points_histories");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }
    public function destroy(string $id, objService $service)
    {
        $service->deleteWithFiles($id);
        return jsonSuccess();

    }
}
