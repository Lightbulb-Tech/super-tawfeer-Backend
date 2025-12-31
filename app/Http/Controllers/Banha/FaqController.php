<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banha\FaqRequest as objRequest;
use App\Services\Banha\FaqService as objService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    private string $folderPath = 'banha.faqs.';
    private string $mainRoute = 'faqs';

    public function index(Request $request, objService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataForDataTable();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('question', function ($row) {
                    return Str::limit($row->question, 25, '...');
                })
                ->editColumn('answer', function ($row) {
                    return Str::limit($row->answer, 25, '...');
                })
                ->addColumn('actions', function ($row) {
                    $editButton = editBtn($this->mainRoute, $row->id, $row->title);
                    $deleteButton = deleteBtn($this->mainRoute, $row->id);
                    return $editButton . ' ' . $deleteButton;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $data["createRoute"] = route($this->mainRoute . ".create");
        $data["dataTableRoute"] = route($this->mainRoute . ".index");
        $data["bladeTitle"] = __("banha.faqs");
        $data["addButtonText"] = __("banha.faqs");
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
