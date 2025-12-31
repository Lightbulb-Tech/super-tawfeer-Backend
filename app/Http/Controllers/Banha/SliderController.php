<?php

namespace App\Http\Controllers\Banha;

use App\Enums\ModulesTypeisEnum;
use App\Enums\SliderTypeisEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\SliderRequest as objRequest;
use App\Models\Banha\Category;
use App\Models\Banha\Product;
use App\Services\Banha\SliderService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    private string $folderPath = 'banha.sliders.';
    private string $mainRoute = 'sliders';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('type', function ($row) {
                    return SliderTypeisEnum::tryFrom($row->type)->lang();
                })
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.sliders");
        $data["addButtonText"] = __("banha.sliders");
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
                    'types' => SliderTypeisEnum::cases(),
                    'moduleNames' => ModulesTypeisEnum::cases(),
                    'products' => Product::query()
                        ->join('product_translations', function ($join) {
                            $join->on('products.id', '=', 'product_translations.product_id')
                                ->where('product_translations.locale', app()->getLocale());
                        })->pluck('product_translations.title', 'products.id')->toArray(),
                    'categories' => Category::query()
                        ->join('category_translations', function ($join) {
                            $join->on('categories.id', '=', 'category_translations.category_id')
                                ->where('category_translations.locale', app()->getLocale());
                        })->pluck('category_translations.title', 'categories.id')->toArray(),
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
        $data = $service->storeWithFiles($dataInsert);
        return jsonSuccess($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
                'types' => SliderTypeisEnum::cases(),
                'moduleNames' => ModulesTypeisEnum::cases(),
                'products' => Product::query()
                    ->join('product_translations', function ($join) {
                        $join->on('products.id', '=', 'product_translations.product_id')
                            ->where('product_translations.locale', app()->getLocale());
                    })->pluck('product_translations.title', 'products.id')->toArray(),
                'categories' => Category::query()
                    ->join('category_translations', function ($join) {
                        $join->on('categories.id', '=', 'category_translations.category_id')
                            ->where('category_translations.locale', app()->getLocale());
                    })->pluck('category_translations.title', 'categories.id')->toArray(),
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
