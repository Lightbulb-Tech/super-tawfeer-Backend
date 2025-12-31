<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\ImportProductRequest as objRequest;
use App\Jobs\ProcessExcelJob;
use App\Services\Banha\BrandService;
use App\Services\Banha\FaqService as objService;
use App\Services\Banha\MainCategoryService;

class ImportProductController extends Controller
{
    private string $folderPath = 'banha.products.import.';
    private string $mainRoute = 'import-products';

    public function create(objService $service, MainCategoryService $mainCategoryService, BrandService $brandService)
    {
        if (request()->ajax()) {
            $html = view($this->folderPath . 'create')
                ->with([
                    'storeRoute' => route($this->mainRoute . '.store'),
                    'mainCategories' => $mainCategoryService->getMainCategories(),
                    'brands' => $brandService->get(),
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
        $filePath = $dataInsert['file']->store('imports');
        ProcessExcelJob::dispatch(
            $filePath,
            $dataInsert['main_category_id'],
            $dataInsert['sub_category_id'],
            $dataInsert['brand_id']
        );
        return jsonSuccess();
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
