<?php

namespace App\Http\Controllers\Banha;

use App\Enums\DriverStatusEnum;
use App\Enums\OfferTypeisEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\ProductRequest as objRequest;
use App\Services\Banha\BrandService;
use App\Services\Banha\MainCategoryService;
use App\Services\Banha\ProductImageService;
use App\Services\Banha\DriverService as objService;
use App\Services\Banha\SubCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class MostDriverDeliveriesController extends Controller
{
    private string $folderPath = 'banha.most_drivers_deliveries.';
    private string $mainRoute = 'most-drivers-deliveries';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getMostDriversDeliveriesDataForDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->addColumn('number_of_orders', function ($row) {
                    return '<span class="badge bg-success">'.  $row->completedOrder()->count().'</span>';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == DriverStatusEnum::Available->value){
                        return '<span class="badge bg-success">'. DriverStatusEnum::tryFrom($row->status)->lang().'</span>';
                    } else{
                        return '<span class="badge bg-danger">' . DriverStatusEnum::tryFrom($row->status)->lang() . '</span>';
                    }
                })
//                ->addColumn('actions', function ($row) {
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
//                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
//                    return $editButton . ' ' . $deleteButton;
//                })
                ->rawColumns(['actions', 'image','status','number_of_orders'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.most_drivers_deliveries");
        $data["addButtonText"] = __("banha.products");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

}
