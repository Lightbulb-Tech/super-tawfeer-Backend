<?php

namespace App\Http\Controllers\TamoTech\Env;

use App\Enums\AdminTypeisEnum;
use App\Http\Controllers\Controller;
use App\Services\TamoTech\EnvService as ObjService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class EnvController extends Controller
{
    public string $folderPath = "tamotech.env";
    public string $mainRoute = "env";

    public function index(Request $request, ObjService $service)
    {
        if (auth('admin')->user()->admin_type == AdminTypeisEnum::Developer->value) {
            $envs = $service->getindex();
            $createRoute = route($this->mainRoute . '.create');
            return view($this->folderPath . '.index', compact('envs','createRoute'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $returnHTML = view($this->folderPath . '.create')->with([
                'storeRoute' => route($this->mainRoute . ".store"),
            ])->render();
            return jsonSuccess(["html" => $returnHTML]);
        }
    }

    public function store(Request $request, ObjService $service)
    {
        $data = $service->storeKey($request->key, $request->value);
        return jsonSuccess($data, null, 201);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function update(Request $request, ObjService $service, $id)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            try {
                $service->storeKey($key, $value ?? '');
            } catch (\Exception $e) {
                Log::error("Failed to store key: $key with value: $value. Error: " . $e->getMessage());
            }
        }

        // الأمر الصحيح
        Artisan::call('config:clear');

        return jsonSuccess(null, '✅ تم الحفظ، سيتم تطبيق التغييرات عند تحديث الصفحة.', 201);
    }



    public function destroy($id, Request $request, ObjService $service)
    {
        $data = $service->deleteVariable($request->key);
        return jsonSuccess($data, '✅ تم الحفظ، سيتم تطبيق التغييرات عند تحديث الصفحة.', 201);
    }
}
