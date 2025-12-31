<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\SubCategoryRequest as objRequest;
use App\Services\Banha\MainCategoryService;
use App\Services\Banha\SubCategoryService as objService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class SubCategoryController extends Controller
{
    private string $folderPath = 'banha.sub_categories.';
    private string $mainRoute = 'sub-categories';

    public function index(Request $request, objService $service , MainCategoryService $mainCategoryService)
    {
        if ($request->ajax()) {
            $data = $service->getDataForDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return show_image($row->image);
                })
                ->editColumn('main_category_id', function ($row) {
                    return $row->mainCategory->title ?? '-';
                })
                ->editColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" class="toggle-switch" data-id="' . $row->id . '" data-field="is_active" ' . $checked . '>
                                <span class="slider round"></span>
                            </label>';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('main_category_id')) {
                        $query->where('main_category_id', $request->main_category_id);
                    }
                })
                ->rawColumns(['actions','image','is_active','main_category_id'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.sub_categories");
        $data["addButtonText"] = __("banha.sub_categories");
        $data["main_categories"] = $mainCategoryService->getMainCategories();

        $data["modelSize"] = 'xl';
        return view($this->folderPath . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(objService $service , MainCategoryService $mainCategoryService)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                    'main_categories' => $mainCategoryService->getMainCategories(),
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, objService $service , MainCategoryService $mainCategoryService)
    {
        $html = view($this->folderPath . 'edit')
            ->with([
                'updateRoute' => route($this->mainRoute . '.update', $id),
                'obj' => $service->find($id),
                'main_categories' => $mainCategoryService->getMainCategories(),
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
