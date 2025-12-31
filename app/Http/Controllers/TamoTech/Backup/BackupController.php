<?php

namespace App\Http\Controllers\TamoTech\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class BackupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function makeBackup(Request $request)
    {
        Artisan::call('backup:sql');
        $path = trim(Artisan::output());
        if (!file_exists($path)) {
            return response()->json(['message' => 'Backup not found', 'path' => $path], 404);
        }
        $relativePath = Str::after($path, 'storage');
        $finalPath = DIRECTORY_SEPARATOR . 'storage' . $relativePath;

        return response()->download($path, basename($path));
    }
}
