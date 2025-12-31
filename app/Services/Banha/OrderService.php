<?php

namespace App\Services\Banha;

use App\Enums\DriverStatusEnum;
use App\Enums\NotificationTypesEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentTypesEnum;
use App\Enums\PointHistoryStatusEnum;
use App\Enums\WalletOperationEnum;
use App\Enums\WalletStatusEnum;
use App\Repositories\Banha\AddressRepository;
use App\Repositories\Banha\CartRepository;
use App\Repositories\Banha\CouponRepository;
use App\Repositories\Banha\DriverRepository;
use App\Repositories\Banha\OrderCancellationRepository;
use App\Repositories\Banha\OrderDetailsRepository;
use App\Repositories\Banha\OrderRepository;
use App\Repositories\Banha\PointHistoryRepository;
use App\Repositories\Banha\ProductRepository;
use App\Repositories\Banha\ReasonCancellationRepository;
use App\Repositories\Banha\UserRepository;
use App\Repositories\Banha\WalletHistoryRepository;
use App\Traits\Firebase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\MpdfException;

class OrderService
{
    use Firebase;
    public function __construct(private OrderRepository        $repository, private CouponRepository $couponRepository, private ProductRepository $productRepository,
                                private UserRepository         $userRepository, private AddressRepository $addressRepository, private ReasonCancellationRepository $reasonCancellationRepository,
                                private PointHistoryRepository $pointHistoryRepository, private OrderCancellationRepository $orderCancellationRepository, private WalletHistoryRepository $walletHistoryRepository,
                                private CartRepository $cartRepository, private OrderDetailsRepository $orderDetailsRepository, private DriverRepository $driverRepository, private NotificationService $notificationService)
    {

    }

    public function getDataTable()
    {
        return $this->repository->getDataTable();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function first()
    {
        return $this->repository->first();
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function storeWithFiles($data)
    {
        return $this->repository->storeWithFiles($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }


    public function updateWithFiles($id, $data)
    {
        return $this->repository->updateWithFiles($id, $data);

    }

    public function deleteWithFiles($id): bool
    {
        return $this->repository->deleteWithFiles($id);

    }

    public function get()
    {
        return $this->repository->get();
    }

    public function getWhere($where)
    {
        return $this->repository->getWhere($where)->get();
    }

    public function getOrders(array $status, $user)
    {
        return $this->repository->getOrders($status, $user);
    }

    public function getOrdersForDataTable(array $status)
    {
        return $this->repository->getOrdersForDataTable($status);
    }

    public function makeOrder($data)
    {
        $user = $this->userRepository->find($data['user_id']);

        if ($user->carts->isEmpty()) {
            return ['error' => __("api.this_user_has_not_products_in_cart")];
        }

        $data['status'] = OrderStatusEnum::Pending->value;
        $data['code'] = $this->generateUniqueOrderCode();
        $app_settings = app('app-settings')->first();
        $appCommission = isset($app_settings) ? $app_settings->app_commission : 0.0;
        $pointPrice = isset($app_settings) ? $app_settings->point_price : 0.0;
        $data['app_commission'] = (double)$appCommission;
        if (!isset($user->checked_address)) {
            return ['error' => __("api.you_must_enter_your_address")];
        }


        $data = $this->getAddressData($user, $data);

        $cartProducts = $this->cartRepository->getWhere(['user_id' => $data['user_id']]);

        $data = $this->getProductsPriceFromCart($cartProducts, $data);
        $data = $this->getProductsPointsFromCart($cartProducts, $data);

        $data['coupon_discount'] = 0.0;

        $data['final_price'] = $data['products_price'] + ($data['app_commission'] + $data['shipping_price']);

        if (isset($data['coupon_id'])) {
            $coupon = $this->couponRepository->find($data['coupon_id']);
            $data['coupon_type'] = $coupon->type;
            $data['coupon_value'] = $coupon->value;
            $data['coupon_discount'] = calculatePriceAfterCoupon($data['products_price'], $coupon)['discount'];
            $data['final_price'] = calculatePriceAfterCoupon($data['products_price'], $coupon)['final_price'] + ($data['app_commission'] + $data['shipping_price']);
        }

        $toDay = Carbon::now()->format('l');
        if (in_array($toDay, $app_settings->days)) {
            $data['final_price'] = $data['final_price'] - $data['shipping_price'];
        }

        if ($data['payment_type'] == PaymentTypesEnum::Wallet->value) {
            $wallet = @$user->wallet;
            if (!isset($wallet)) {
                return ['error' => __("api.this_user_has_not_wallet_record")];
            }
            if ($wallet->amount < $data['final_price']) {
                return ['error' => __("api.this_user_has_not_enough_balance")];
            }
        }
        $order = $this->store($data);
        $this->storeOrderDetails($order, $cartProducts);
        $this->storePointHistory($pointPrice, $order);
        $this->updateOrderProductsAmount($order->details);
        $user->carts()->delete();
//        $this->createInvoicePdf($order);
        return $order;

    }

    public function updateOrderProductsAmount($orderProducts)
    {
        foreach ($orderProducts as $orderProduct) {
            $product = $this->productRepository->find($orderProduct->product_id);
            $product->update(['reserved_amount' => $product->reserved_amount + $orderProduct->quantity]);
        }
        return true;

    }

    public function generateUniqueOrderCode()
    {
        do {
            $code = '#' . rand(1000, 9999) . '-' . rand(10000000, 99999999);
            $exists = DB::table('orders')->where('code', $code)->exists();
        } while ($exists);
        return $code;
    }

    public function getAddressData($user, $data)
    {
        $app_settings = app('app-settings')->first();
        $area = @$this->addressRepository->find($user->checked_address)->area;
        $toDay = Carbon::now()->format('l');
        if (in_array($toDay, $app_settings->days)) {
            $data['shipping_price'] =  0.0;
        } else {
            $data['shipping_price'] = (double)$area->shipping_price ?? 0.0;
        }
        $data['area_id'] = $area->id;
        $data['lat'] = $area->lat;
        $data['lon'] = $area->lon;
        return $data;
    }

    public function getProductsPriceFromCart($cartProducts, $data)
    {
        $data['products_price'] = $cartProducts->sum(function ($cartProduct) {
            return $cartProduct->final_price * $cartProduct->quantity;
        });
        return $data;
    }

    public function getProductsPointsFromCart($cartProducts, $data)
    {
        $data['total_points'] = $cartProducts->sum(function ($cartProduct) {
            return $cartProduct->points * $cartProduct->quantity;
        });
        return $data;
    }

    public function storeOrderDetails($order, $cartProducts)
    {
        foreach ($cartProducts as $cartProduct) {
            $this->orderDetailsRepository->store([
                'order_id' => $order->id,
                'product_id' => $cartProduct->product_id,
                'price' => @$cartProduct->price,
                'product_point' => $cartProduct->points,
                'quantity' => $cartProduct->quantity,
                'offer_id' => $cartProduct->offer_id,
                'offer_type' => $cartProduct->offer_type,
                'offer_value' => $cartProduct->offer_value,
                'offer_discount' => $cartProduct->offer_discount,
                'final_price' => $cartProduct->final_price,
            ]);
        }
        return $order;
    }

    public function storePointHistory($point_price, $order)
    {
        return $this->pointHistoryRepository->store([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'points' => $order->total_points,
            'price' => (double)$order->total_points * $point_price,
            'status' => PointHistoryStatusEnum::Pending->value,
        ]);
    }

    public function confirmOrder($order)
    {
        $user = $this->userRepository->find($order->user_id);
        $order->update(['status' => OrderStatusEnum::Confirmed->value]);
        $objPointHistory = $order->pointHistory;
        if (isset($objPointHistory)) {
            $objPointHistory->update(['status' => PointHistoryStatusEnum::Success->value]);
        }
        $user->update(['points' => $user->points + $order->total_points]);

        $orderProducts = $order->details;
        foreach ($orderProducts as $orderProduct) {
            $product = $this->productRepository->find($orderProduct->product_id);
            $product->update([
                'reserved_amount' => $product->reserved_amount - $orderProduct->quantity,
                'amount' => $product->amount - $orderProduct->quantity,
                'max_quantity_for_order' => $product->max_quantity_for_order - $orderProduct->quantity,
                'ordered_count' => $product->ordered_count + 1,
                'sold_count' => $product->sold_count + $orderProduct->quantity,
            ]);
        }
        $this->sendNotificationWhenUpdateOrderStatus(
            $user->id,
            NotificationTypesEnum::OrderConfirmed->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_has_been_successfully_confirmed_please_track_its_status"),
        );
        if ($order->payment_type == PaymentTypesEnum::Wallet->value) {
            $wallet = $user->wallet;
            $wallet->update(['amount' => $wallet->amount - $order->final_price]);
            $this->walletHistoryRepository->store([
                'user_id' => $user->id,
                'status' => WalletStatusEnum::Success->value,
                'operation' => WalletOperationEnum::PayOrder->value,
                'amount' => -$order->final_price,
            ]);
            $this->sendNotificationWhenUpdateOrderStatus(
                $user->id,
                NotificationTypesEnum::PayOrderFromWallet->action(),
                $order->id,
                __("api.pay_order"),
                __("api.your_order_is_paid_via_wallet"),
            );
        }
        return true;
    }

    public function startPrepareOrder($order)
    {
        $order->update(['status' => OrderStatusEnum::InProgress->value]);
        $this->sendNotificationWhenUpdateOrderStatus(
            @$order->user->id,
            NotificationTypesEnum::OrderPrepared->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_is_being_processed_please_track_its_status"),
        );
        return true;
    }

    public function deliverOrderToDriver($order)
    {
        if (!isset($order->driver_id) && $order->driver_id == null) {
            return ['error' => __("banha.you_must_first_choose_driver_to_this_order")];
        }
        $order->update(['status' => OrderStatusEnum::OnTheWay->value]);
        $this->sendNotificationWhenUpdateOrderStatus(
            @$order->user->id,
            NotificationTypesEnum::OrderDeliveredToDriver->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_is_delivered_to_driver_please_track_its_status") . __("banha.driver_name") . " : " . @$order->driver->name . ' , ' . __("banha.driver_phone") . " : " . @$order->driver->phone,
        );
        return true;
    }

    public function deliverOrderToClient($order)
    {
        $order->update(['status' => OrderStatusEnum::Delivered->value]);
        $driver = $this->driverRepository->find($order->driver_id);
        $driver->update(['status' => DriverStatusEnum::Available->value]);
        $this->sendNotificationWhenUpdateOrderStatus(
            @$order->user->id,
            NotificationTypesEnum::OrderDeliveredToClient->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_is_delivered_to_client"),
        );
        return true;
    }

    public function cancelOrderFromAdmin($order)
    {
        // احفظ الحالة القديمة قبل التغيير
        $oldStatus = $order->status;

        // الغاء الطلب
        $order->update(['status' => OrderStatusEnum::CanceledFromAdmin->value]);

        // نقاط الطلب
        $objPointHistory = $order->pointHistory;
        if ($objPointHistory) {
            $objPointHistory->update(['status' => PointHistoryStatusEnum::Failed->value]);
        }

        $orderProducts = $order->details;

        //-----------------------------------------
        // الحالة (1): Pending → reserved فقط
        //-----------------------------------------
        if ($oldStatus === OrderStatusEnum::Pending->value) {

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productRepository->find($orderProduct->product_id);

                $product->update([
                    'reserved_amount' => $product->reserved_amount - $orderProduct->quantity,
                ]);
            }

        }

        //-----------------------------------------
        // الحالة (2): Confirmed / InProgress / OnTheWay
        // رجّع كل المخزون
        //-----------------------------------------
        if (in_array($oldStatus, [OrderStatusEnum::Confirmed->value, OrderStatusEnum::InProgress->value, OrderStatusEnum::OnTheWay->value])) {
            foreach ($orderProducts as $orderProduct) {
                $product = $this->productRepository->find($orderProduct->product_id);
                $product->update([
                    'amount'                 => $product->amount + $orderProduct->quantity,
                    'max_quantity_for_order' => $product->max_quantity_for_order + $orderProduct->quantity,
                    'ordered_count'          => $product->ordered_count - 1,
                    'sold_count'             => $product->sold_count - $orderProduct->quantity,
                ]);
            }
        }

        // سجل الالغاء
        $this->orderCancellationRepository->store([
            'order_id' => $order->id,
            'reason' => 'ملغي من الادارة',
            'cancelled_by' => 'admin',
        ]);

        // ارسال اشعار
        $this->sendNotificationWhenUpdateOrderStatus(
            @$order->user->id,
            NotificationTypesEnum::OrderCancelled->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_is_canceled_from_app"),
        );

        return true;
    }


    public function cancelOrderFromUser($data)
    {
        $order = $this->find($data['order_id']);

        if (!$order || $order->status != OrderStatusEnum::Pending->value) {
            return ['error' => __("api.you_cannot_cancel_order_in_this_status")];
        }

        $objPointHistory = $order->pointHistory;
        if (isset($objPointHistory)) {
            $objPointHistory->update(['status' => PointHistoryStatusEnum::Failed->value]);
        }

        $order->update(['status' => OrderStatusEnum::CanceledFromUser->value]);

        if (!empty($data['reason_id'])) {
            $reason = $this->reasonCancellationRepository->find($data['reason_id']);
            $data['reason'] = $reason ? $reason->title : null;
        } elseif (!empty($data['reason'])) {
            $data['reason'] = $data['reason'];
        }

        $orderProducts = $order->details;
        foreach ($orderProducts as $orderProduct) {
            $product = $this->productRepository->find($orderProduct->product_id);
            $product->update([
                'reserved_amount' => $product->reserved_amount - $orderProduct->quantity,
            ]);
        }
        $data['user_id'] = Auth::guard('api')->id();
        $data['cancelled_by'] = 'user';
        $this->sendNotificationWhenUpdateOrderStatus(
            @$order->user->id,
            NotificationTypesEnum::OrderCancelled->action(),
            $order->id,
            __("api.change_order_status"),
            __("api.your_order_is_canceled_by_you"),
        );

        return $this->orderCancellationRepository->store($data);

    }

    public function sendNotificationWhenUpdateOrderStatus($user_id, $action, $operation_id, $title, $message): void
    {
        $this->notificationService->store([
            'to_user_id' => $user_id,
            'action' => $action,
            'operation_id' => $operation_id,
            'title' => $title,
            'message' => $message,
        ]);
        $this->sendMessage((string)$user_id, $title, $message, [
            'notification_type' => $action,
        ]);
    }

    /**
     * @throws MpdfException
     */
    public function createInvoicePdf($order)
    {
        $html = view('banha.invoices.index', compact('order'))->render();
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($html);

        // حدد مسار التخزين داخل storage/app/public/invoices
        $directory = storage_path('app/public/invoices/');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // ينشئ كل المجلدات الفرعية
        }

        // اسم الملف مع استبدال الرموز الغير مسموح بها مثل #
        $fileName = 'invoice-' . str_replace(['#', ' '], '-', $order->code) . '.pdf';
        $filePath = $directory . $fileName;

        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        // خزن مسار الملف النسبي الصحيح للعرض عبر storage
        $order->invoice_pdf = 'invoices/' . $fileName;
        $order->save();

        return $order;
    }





}
