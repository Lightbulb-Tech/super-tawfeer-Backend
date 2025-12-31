<?php

namespace App\Services\TamoTech;

use App\Enums\OrderStatusEnum;
use App\Services\MainService;
use Illuminate\Support\Facades\DB;

class DashboardService extends MainService
{

    public function getCounts()
    {
        return [
            'countries' => DB::table('countries')->count(),
            'sliders' => DB::table('sliders')->count(),
            'reasons' => DB::table('reason_cancellations')->count(),
            'faqs' => DB::table('faqs')->count(),
            'drivers' => DB::table('drivers')->count(),
            'governorates' => DB::table('areas')->where('governorate_id', '=', null)->count(),
            'areas' => DB::table('areas')->where('governorate_id', '!=', null)->count(),
            'main_categories' => DB::table('categories')->where('main_category_id', '=', null)->count(),
            'sub_categories' => DB::table('categories')->where('main_category_id', '!=', null)->count(),
            'products' => DB::table('products')->count(),
            'coupons' => DB::table('coupons')->count(),
            'clients' => DB::table('users')->count(),
            'new_orders' => DB::table('orders')->where('status', '=', OrderStatusEnum::Pending->value)->count(),
            'current_orders' => DB::table('orders')->whereIn('status', [OrderStatusEnum::Confirmed->value, OrderStatusEnum::InProgress->value, OrderStatusEnum::OnTheWay->value])->count(),
            'complete_orders' => DB::table('orders')->where('status', '=', OrderStatusEnum::Delivered->value)->count(),
            'canceled_orders' => DB::table('orders')->whereIn('status', [OrderStatusEnum::CanceledFromAdmin->value, OrderStatusEnum::CanceledFromUser->value, OrderStatusEnum::Returned->value])->count(),
            'total_profits' => DB::table('orders')->where('status', '=', OrderStatusEnum::Delivered->value)->sum('final_price'),
            'total_profits_daily' => DB::table('orders')
                ->where('status', OrderStatusEnum::Delivered->value)
                ->whereDate('created_at', now())
                ->sum('final_price'),

            'total_profits_monthly' => DB::table('orders')
                ->where('status', OrderStatusEnum::Delivered->value)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('final_price'),

            'total_profits_yearly' => DB::table('orders')
                ->where('status', OrderStatusEnum::Delivered->value)
                ->whereYear('created_at', now()->year)
                ->sum('final_price'),
            'total_app_commissions' => DB::table('orders')
                ->where('status', OrderStatusEnum::Delivered->value)
                ->sum('app_commission'),


        ];
    }

}
