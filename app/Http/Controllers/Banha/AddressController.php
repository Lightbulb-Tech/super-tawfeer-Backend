<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Services\Banha\AddressService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AddressController extends Controller
{
    private string $folderPath = 'banha.users_address.';
    private string $mainRoute = 'users-address';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user', function ($row) {
                    return @$row->user->first_name . ' ' . $row->user->last_name;
                })
                ->editColumn('area', function ($row) {
                    return $row->area->title ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'user', 'area'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.users");
        $data["addButtonText"] = __("banha.users");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

}
