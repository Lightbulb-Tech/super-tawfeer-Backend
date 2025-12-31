<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Services\Banha\UserService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private string $folderPath = 'banha.users.';
    private string $mainRoute = 'users';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->addColumn('number_of_orders', function ($row) {
                    return '<span class="badge bg-success">' . $row->orders()->count() . '</span>';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                    $showButton = '';
//                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    if (!$row->orders()->exists()) {
                        $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    }
                    $showButton = showBtn($this->mainRoute, $row->id);

                    return $showButton . ' ' . $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'name', 'image', 'number_of_orders'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.users");
        $data["addButtonText"] = __("banha.users");
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    public function show(string $id, objService $service)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'show')
                ->with([
                    'obj' => $service->find($id),
                ])
                ->render();
            return jsonSuccess(['html' => $html]);
        }
    }

}
