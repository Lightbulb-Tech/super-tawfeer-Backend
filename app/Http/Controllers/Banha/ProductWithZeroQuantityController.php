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


class ProductWithZeroQuantityController extends Controller
{
    private string $folderPath = 'banha.products_with_zero_quantity.';
    private string $mainRoute = 'products-with-zero-quantity';
    private string $attributeRoute = 'product-attribute';

    public function index(Request $request, objService $service, MainCategoryService $mainCategoryService)
    {
        if ($request->ajax()) {
            $data = $service->getDataWithZeroQuantityForDataTable();
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
                ->editColumn('sold_count', function ($row) {
                    return '<span class="badge bg-dark">' . $row->sold_count ?? 0 . '</span>';
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
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
//                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    $showButton = showBtn($this->mainRoute, $row->id);
//                    $attributeButton = '<a href="' . route($this->attributeRoute . '.index', ['productId' => $row->id]) . '">
//                                            <button type="button" class="btn btn-success mb-2">
//                                                <i class="fa fa-plus-circle" style="padding-left: 5px;"></i> ' . __("banha.add_product_attributes") . '
//                                            </button>
//                                        </a>';
                    return $attributeButton . ' ' . $showButton . ' ' . $editButton . ' ' . $deleteButton;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('main_category_id')) {
                        $query->where('main_category_id', $request->main_category_id);
                    }
                    if ($request->filled('sub_category_id')) {
                        $query->where('sub_category_id', $request->sub_category_id);
                    }
                })
                ->rawColumns(['actions', 'image', 'is_active', 'amount', 'main_category', 'sub_category','sold_count','ordered_count'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["importRouteCreate"] = route("import-products.create");
        $data["addProductsWithSheetExcel"] = __("banha.addProductsWithSheetExcel");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.products_with_zero_quantity");
        $data["addButtonText"] = __("banha.products");
        $data["main_categories"] = $mainCategoryService->getMainCategories();
        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objService $service, MainCategoryService $mainCategoryService, BrandService $brandService)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                    'mainCategories' => $mainCategoryService->getMainCategories(),
                    'brands' => $brandService->get(),
                    'offerTypes' => OfferTypeisEnum::cases(),
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objService $service)
    {
        DB::beginTransaction();
        $dataInsert = $request->validated();
        $data = $service->storeProduct($dataInsert);
        DB::commit();
        return jsonSuccess($data);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, objService $service, MainCategoryService $mainCategoryService, SubCategoryService $subCategoryService, BrandService $brandService)
    {
        if (request()->ajax()) {
            $product = $service->find($id);
            $html = view($this->folderPath . 'edit')
                ->with([
                    'updateRoute' => route($this->mainRoute . '.update', $id),
                    'obj' => $product,
                    'mainCategories' => $mainCategoryService->getMainCategories(),
                    'subCategories' => $subCategoryService->getSubCategories($product->main_category_id),
                    'brands' => $brandService->get(),
                    'offerTypes' => OfferTypeisEnum::cases(),
                ])
                ->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, string $id, objService $service)
    {
        DB::beginTransaction();
        $dataInsert = $request->validated();
        $data = $service->updateProduct($id, $dataInsert);
        DB::commit();
        return jsonSuccess($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, objService $service, ProductImageService $productImageService)
    {
        $service->deleteProduct($id);
        return jsonSuccess();

    }
}
