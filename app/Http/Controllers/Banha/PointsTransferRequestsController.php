<?php

namespace App\Http\Controllers\Banha;

use App\Enums\PointsTransferRequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\PointsTransferRequestRequest as objRequest;
use App\Services\Banha\PointsTransferRequestService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PointsTransferRequestsController extends Controller
{
    private string $folderPath = 'banha.points_transfer_requests.';
    private string $mainRoute = 'points-transfer-requests';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user', function ($row) {
                    return @$row->user->first_name . ' ' . $row->user->last_name;
                })
                ->editColumn('user_phone', function ($row) {
                    return @$row->user->phone;
                })
                ->addColumn('point_price', function ($row) {
                    $appSettings = app('app-settings')->first();
                    return isset($appSettings) ? $appSettings->point_price : 0.0;
                })
                ->addColumn('total', function ($row) {
                    $appSettings = app('app-settings')->first();
                    $pointPrice = isset($appSettings) ? $appSettings->point_price : 0.0;
                    return $pointPrice * $row->points;
                })
                ->editColumn('status', function ($row) {
                    $result = '';
                    if ($row->status == PointsTransferRequestStatusEnum::Pending->value) {
                        $result = '
                        <div class="btn-group" role="group">
                            <button class="btn btn-success btn-sm accept-transfer" data-id="' . $row->id . '" data-store-id="' . @$row->id . '">
                                <i class="fas fa-check"></i> ' . __('banha.accept') . '
                            </button>
                            <button class="btn btn-danger btn-sm reject-transfer mx-2" data-id="' . $row->id . '" data-store-id="' . @$row->id . '">
                                <i class="fas fa-times"></i> ' . __('banha.refused') . '
                            </button>
                        </div>';
                    } else if ($row->status == PointsTransferRequestStatusEnum::Accepted->value) {
                        $result = '<span class="badge bg-success">' . PointsTransferRequestStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    } else if ($row->status == PointsTransferRequestStatusEnum::Refused->value) {
                        $result = '<span class="badge bg-danger">' . PointsTransferRequestStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                    return $result;
                })
                ->editColumn('points', function ($row) {
                    return $row->points;
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'user', 'status','total','point_price'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.points_transfer_requests");
        $data["addButtonText"] = __("banha.points_transfer_requests");
        $data["modelSize"] = 'xl';

        return view($this->folderPath . '.index', $data);
    }

    public function update(objRequest $request, int $id, objService $service)
    {
        $dataInsert = $request->validated();
        $obj = $service->find($id);
        $user = $obj->user;
        $dataInsert["user_id"] = $user->id;
        $data = $service->updatePointsTransferRequestStatus($id, $dataInsert);
        return jsonSuccess($data);
    }
    public function destroy(string $id, objService $service)
    {
        $service->deleteWithFiles($id);
        return jsonSuccess();

    }

}
