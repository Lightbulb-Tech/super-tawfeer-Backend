<?php

namespace App\Services\Banha;

use App\Enums\DriverStatusEnum;
use App\Enums\ExternalOrderStatusEnum;
use App\Enums\NotificationTypesEnum;
use App\Repositories\Banha\AreaRepository;
use App\Repositories\Banha\DriverRepository;
use App\Repositories\Banha\ExternalOrderDetailsRepository;
use App\Repositories\Banha\ExternalOrderRepository;
use App\Repositories\Banha\NotificationRepository;
use App\Traits\Firebase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternalOrderService
{
    use Firebase;

    public function __construct(private ExternalOrderRepository $repository, private readonly AreaRepository $areaRepository, private readonly NotificationRepository $notificationRepository, private readonly ExternalOrderDetailsRepository $externalOrderDetailsRepository, private readonly DriverRepository $driverRepository)
    {

    }

    public function makeExternalOrder($data)
    {
        $data['code'] = $this->generateUniqueReservationCode();
        $data['status'] = ExternalOrderStatusEnum::Pending->value;
        if (Auth::guard('api')->check()) {
            $data['user_id'] = Auth::guard('api')->user()->id;
        }
        $area = $this->areaRepository->find($data['area_id']);
        $data['shipping_price'] = $area->shipping_price;
        $data['final_price'] = $data['shipping_price'];
        $external_order = $this->store($data);
        $data['external_order_id'] = $external_order->id;
        $this->externalOrderDetailsRepository->storeExternalOrderDetails($data);
        return $external_order;
    }

    public function generateUniqueReservationCode(): string
    {
        do {
            $code = '#' . rand(10000000, 99999999);
            $exists = DB::table('external_orders')->where('code', $code)->exists();
        } while ($exists);
        return $code;
    }

    public function updateExternalOrderStatus($external_order, $status)
    {
        if ($status == ExternalOrderStatusEnum::Confirmed->value) {
            $external_order->update(['status' => $status]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderConfirmed->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_has_been_successfully_confirmed_please_track_its_status"),
                );
            }
        } else if ($status == ExternalOrderStatusEnum::CanceledFromAdmin->value) {
            $external_order->update(['status' => $status]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderCancelled->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_is_canceled_from_app"),
                );
            }
        } else if ($status == ExternalOrderStatusEnum::InProgress->value) {
            $external_order->update(['status' => $status]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderPrepared->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_is_being_processed_please_track_its_status"),
                );
            }
        } else if ($status == ExternalOrderStatusEnum::OnTheWay->value) {
            if (!isset($external_order->driver_id) && $external_order->driver_id == null) {
                return ['error' => __("banha.you_must_first_choose_driver_to_this_order")];
            }
            $external_order->update(['status' => $status]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderDeliveredToDriver->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_is_delivered_to_driver_please_track_its_status") . __("banha.driver_name") . " : " . @$external_order->driver->name . ' , ' . __("banha.driver_phone") . " : " . @$external_order->driver->phone,
                );
            }
        } else if ($status == ExternalOrderStatusEnum::Delivered->value) {
            if (!isset($external_order->orders_price) && $external_order->orders_price == null) {
                return ['error' => __("banha.you_must_first_write_orders_price_to_this_order")];
            }
            $external_order->update(['status' => $status]);
            $driver = $external_order->driver;
            $driver->update(['status' => DriverStatusEnum::Available->value]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderDeliveredToClient->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_is_delivered_to_client"),
                );
            }
        } else if ($status == ExternalOrderStatusEnum::CanceledFromUser->value) {
            $external_order->update(['status' => $status]);
            $driver = $external_order->driver;
            $driver->update(['status' => DriverStatusEnum::Available->value]);
            if (isset($external_order->user_id)) {
                $this->sendNotificationWhenUpdateReservationStatus(
                    @$external_order->user->id,
                    NotificationTypesEnum::OrderCancelled->action(),
                    $external_order->id,
                    __("api.change_order_status"),
                    __("api.your_order_is_canceled_by_you"),
                );
            }
        }

    }


    public function getExternalForApi(array $status, $user = null): array|\Illuminate\Database\Eloquent\Builder
    {
        return $this->repository->getExternalForApi($status, $user);
    }

    public function getExternalOrdersForDataTable(array $status): \Illuminate\Database\Eloquent\Builder
    {
        return $this->repository->getExternalOrdersForDataTable($status);
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

    public function storeWithFilesWithOneLanguage($data)
    {
        return $this->repository->storeWithFilesWithOneLanguage($data);
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
        return $this->repository->getWhere($where);
    }

    public function sendNotificationWhenUpdateReservationStatus($user_id, $action, $operation_id, $title, $message): void
    {
        $this->notificationRepository->store([
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
}
