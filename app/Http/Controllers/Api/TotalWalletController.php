<?php

namespace App\Http\Controllers\Api;

use App\Enums\WalletStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Banha\WalletService as objService;
use Illuminate\Support\Facades\Auth;

class TotalWalletController extends Controller
{
    public function index(objService $service)
    {
        $user = Auth::guard('api')->user();
        $wallet = $service->getWhere(['user_id' => $user->id, 'status' => WalletStatusEnum::Success->value]);
        $totalWallet = $wallet->sum('amount');
        return jsonSuccess(['total_wallet' => $totalWallet]);
    }

}
