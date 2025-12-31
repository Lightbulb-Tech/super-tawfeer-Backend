<?php

namespace App\Http\Controllers\Banha;

use App\Enums\OfferTypeisEnum;
use App\Http\Controllers\Controller;

use App\Services\Banha\ProductImageService as objService;



class ProductImageController extends Controller
{
    public function destroy(string $id, objService $service)
    {
        $service->deleteWithFiles($id);
        return jsonSuccess();
    }
}
