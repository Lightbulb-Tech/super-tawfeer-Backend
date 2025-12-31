<?php

namespace App\Http\Controllers\TamoTech;

use App\Http\Controllers\Controller;
use App\Services\TamoTech\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request , DashboardService  $service)
    {
        $counts = $service->getCounts();
        return view('tamotech.dashboard' ,compact('counts'));
    }
}
