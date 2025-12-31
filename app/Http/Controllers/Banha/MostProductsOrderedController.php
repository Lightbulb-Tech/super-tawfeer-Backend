<?php

namespace App\Http\Controllers\Banha;

use App\Enums\OfferTypeisEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\ProductRequest as objRequest;
use App\Services\Banha\BrandService;
use App\Services\Banha\MainCategoryService;
use App\Services\Banha\ProductImageService;
use App\Services\Banha\ProductService as objService;
use App\Services\Banha\SubCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class MostProductsOrderedController extends Controller
{
    private string $folderPath = 'banha.most_products_ordered.';
    private string $mainRoute = 'most-products-ordered';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getMostProductsOrderedForDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->editColumn('amount', function ($row) {
                    if ($row->amount > 0) {
                        return '<span class="badge bg-success">' . $row->amount . '</span>';
                    } else {
                        return '<span class="badge bg-danger">' . $row->amount . '</span>';
                    }
                })
                ->editColumn('ordered_count', function ($row) {
                    return '<span class="badge bg-dark">' . $row->ordered_count ?? 0 . '</span>';
                })
                ->editColumn('main_category', function ($row) {
                    return $row->mainCategory->title ?? '-';
                })
                ->editColumn('sub_category', function ($row) {
                    return $row->subCategory->title ?? '-';
                })
                ->editColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" class="toggle-switch" data-id="' . $row->id . '" data-field="is_active" ' . $checked . '>
                                <span class="slider round"></span>
                            </label>';
                })
                ->addColumn('actions', function ($row) {
                    $deleteButton = '';
                    $attributeButton = '';
                    $showButton = '';
                    $showButton = showBtn($this->mainRoute, $row->id);
                    return $showButton;
                })
                ->rawColumns(['actions', 'image', 'is_active', 'amount', 'main_category', 'sub_category', 'sold_count', 'ordered_count'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["importRouteCreate"] = route("import-products.create");
        $data["addProductsWithSheetExcel"] = __("banha.addProductsWithSheetExcel");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.most_products_orders");
        $data["addButtonText"] = __("banha.products");
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
