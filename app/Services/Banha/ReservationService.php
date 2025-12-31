<?php

namespace App\Services\Banha;

use App\Enums\NotificationTypesEnum;
use App\Enums\ReservationStatusEnum;
use App\Enums\VehicleStatusEnum;
use App\Repositories\Banha\CouponRepository;
use App\Repositories\Banha\NotificationRepository;
use App\Repositories\Banha\ReservationRepository;
use App\Repositories\Banha\VehicleRepository;
use App\Traits\Firebase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    use Firebase;

    public function __construct(private ReservationRepository $repository, private readonly CouponRepository $couponRepository, private readonly NotificationRepository $notificationRepository, private readonly VehicleRepository $vehicleRepository)
    {

    }

    public function makeReservation($data)
    {
        if (Auth::guard('api')->check()) {
            $data['user_id'] = Auth::guard('api')->user()->id;
        }
        $data['status'] = ReservationStatusEnum::Pending->value;
        $data['code'] = $this->generateUniqueReservationCode();
        $data['price_of_km'] = $this->vehicleRepository->find($data['vehicle_id'])->price_of_km;
        $data['number_of_km'] = $this->calculateDistance($data['second_lat'], $data['second_lon'], $data['first_lat'], $data['first_lon']);
        $data['price'] = $data['price_of_km'] * $data['number_of_km'];
        $data['final_price'] = $data['price'];
        if (isset($data['coupon_id'])) {
            $coupon = $this->couponRepository->find($data['coupon_id']);
            $data['coupon_type'] = $coupon->type;
            $data['coupon_value'] = $coupon->value;
            $data['coupon_discount'] = calculatePriceAfterCoupon($data['price'], $coupon)['discount'];
            $data['final_price'] = calculatePriceAfterCoupon($data['price'], $coupon)['final_price'];
        }
        return $this->store($data);
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $url = "https://router.project-osrm.org/route/v1/driving/$lon1,$lat1;$lon2,$lat2?overview=false";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if (isset($data['routes'][0]['distance'])) {
            return round($data['routes'][0]['distance'] / 1000, 2);
        }
        return 0;
    }

    public function generateUniqueReservationCode(): string
    {
        do {
            $code = '#' . rand(10000000, 99999999);
            $exists = DB::table('vehicle_reservations')->where('code', $code)->exists();
        } while ($exists);
        return $code;
    }

    public function updateReservationStatus($reservation, $status): void
    {
        $vehicle = $reservation->vehicle;
        if ($status == ReservationStatusEnum::Confirmed->value) {
            $reservation->update(['status' => $status]);
            $vehicle->update(['status' => VehicleStatusEnum::NotAvailable->value]);
            if (isset($reservation->user_id)) {
                $title = __("api.reservation_status_has_changed");
                $message = __("api.your_reservation_is_confirmed_please_track_your_reservation");
                $this->sendNotificationWhenUpdateReservationStatus(
                    $reservation->user_id,
                    NotificationTypesEnum::ReservationConfirmed->action(),
                    $reservation->id,
                    $title,
                    $message
                );
            }
        } else if ($status == ReservationStatusEnum::CanceledFromAdmin->value) {
            $reservation->update(['status' => $status]);
            if (isset($reservation->user_id)) {
                $title = __("api.reservation_status_has_changed");
                $message = __("api.your_reservation_is_canceled_from_app");
                $this->sendNotificationWhenUpdateReservationStatus(
                    $reservation->user_id,
                    NotificationTypesEnum::ReservationCancelled->action(),
                    $reservation->id,
                    $title,
                    $message
                );
            }
        } else if ($status == ReservationStatusEnum::Loading->value) {
            $reservation->update(['status' => $status]);
            if (isset($reservation->user_id)) {
                $title = __("api.reservation_status_has_changed");
                $message = __("api.your_driver_is_now_to_delivery_location");
                $this->sendNotificationWhenUpdateReservationStatus(
                    $reservation->user_id,
                    NotificationTypesEnum::ReservationLoading->action(),
                    $reservation->id,
                    $title,
                    $message
                );
            }
        } else if ($status == ReservationStatusEnum::Completed->value) {
            $reservation->update(['status' => $status]);
            $vehicle->update(['status' => VehicleStatusEnum::Available->value]);
            if (isset($reservation->user_id)) {
                $title = __("api.reservation_status_has_changed");
                $message = __("api.your_reservation_is_completed_thanks_for_choose_us");
                $this->sendNotificationWhenUpdateReservationStatus(
                    $reservation->user_id,
                    NotificationTypesEnum::ReservationCompleted->action(),
                    $reservation->id,
                    $title,
                    $message
                );
            }
        }
    }

    public function getReservationForApi(array $status, $user = null): array|\Illuminate\Database\Eloquent\Builder
    {
        return $this->repository->getReservationForApi($status , $user );
    }

    public function getReservationForDataTable(array $status): \Illuminate\Database\Eloquent\Builder
    {
        return $this->repository->getReservationForDataTable($status);
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
