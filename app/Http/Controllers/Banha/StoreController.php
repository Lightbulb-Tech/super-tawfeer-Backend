<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\StoreRequest as objRequest;
use App\Services\Banha\StoreFeatureService;
use App\Services\Banha\StoreService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StoreController extends Controller
{
    private string $folderPath = 'banha.stores.';
    private string $mainRoute = 'stores';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('logo', function ($row) {
                    return show_image($row->logo);
                })
                ->editColumn('cover_image', function ($row) {
                    return show_image($row->cover_image);
                })
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions', 'logo', 'cover_image'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.stores");
        $data["addButtonText"] = __("banha.stores");
        $data["modelSize"] = 'fullscreen';
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
                ])->render();
            return jsonSuccess(['html' => $html]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(objRequest $request, objService $service, StoreFeatureService $storeFeatureService)
    {
        try {
            DB::beginTransaction();
            $dataInsert = $request->validated();
            $data = $service->storeWithFiles($dataInsert);
            $storeFeatureService->storeFeatures($dataInsert['features'], $data->id);
            DB::commit();
            return jsonSuccess($data);
        } catch (\Exception $exception) {
            DB::rollBack();
            return jsonSuccess(null, $exception->getMessage());
        }

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
            ])
            ->render();
        return jsonSuccess(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(objRequest $request, string $id, objService $service, StoreFeatureService $storeFeatureService)
    {
        try {
            DB::beginTransaction();
            $dataInsert = $request->validated();
            $data = $service->updateWithFiles($id, $dataInsert);
            $featuresNew = [];
            $featuresOld = [];
            $deletedFeatures = [];
            $dataInsert['featuresIds'] = $dataInsert['featuresIds'] ?? []; // 👈 هنا الحل
            if (!empty($dataInsert['features'] ?? [])) {
                $sentFeatureIds = collect($dataInsert['features'])
                    ->filter(fn($f) => isset($f['id']))
                    ->pluck('id')
                    ->toArray();
                $deletedFeatures = array_diff($dataInsert['featuresIds'], $sentFeatureIds);
                foreach ($dataInsert['features'] as $feature) {
                    if (isset($feature['id']) && in_array($feature['id'], $dataInsert['featuresIds'])) {
                        $featuresOld[] = $feature;
                    } else {
                        $featuresNew[] = $feature;
                    }
                }
                if (!empty($featuresNew)) {
                    $storeFeatureService->storeFeatures($featuresNew, $id);
                }
                if (!empty($featuresOld)) {
                    $storeFeatureService->updateFeatures($featuresOld, $id);
                }
            } else {
                $deletedFeatures = $dataInsert['featuresIds'];
            }
            if (!empty($deletedFeatures)) {
                $storeFeatureService->deleteFeatures($deletedFeatures);
            }

            DB::commit();
            return jsonSuccess($data);
        } catch (\Exception $exception) {
            DB::rollBack();
            return jsonSuccess(null, $exception->getMessage());
        }
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
