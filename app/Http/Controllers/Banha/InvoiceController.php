<?php

namespace App\Http\Controllers\Banha;

use App\Http\Controllers\Controller;
use App\Services\Banha\OrderService;

class InvoiceController extends Controller
{
    private string $folderPath = 'banha.invoices.';
    private string $mainRoute = 'invoices';

    public function show(string $id, OrderService $orderService)
    {
        $order = $orderService->find($id);
        return view($this->folderPath . 'index',get_defined_vars());

    }


}
