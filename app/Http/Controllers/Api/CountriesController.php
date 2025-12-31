<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource as objResource;
use App\Services\Banha\CountryService;

class CountriesController extends Controller
{
    public function index(CountryService $service)
    {
        $data = $service->get();
        return jsonSuccess(objResource::collection($data));
    }

}
