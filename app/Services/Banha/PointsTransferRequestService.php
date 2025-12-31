<?php

namespace App\Services\Banha;

use App\Enums\NotificationTypesEnum;
use App\Enums\PointsTransferRequestStatusEnum;
use App\Enums\WalletOperationEnum;
use App\Enums\WalletStatusEnum;
use App\Repositories\Banha\AppSettingsRepository;
use App\Repositories\Banha\NotificationRepository;
use App\Repositories\Banha\PointsTransferRequestRepository;
use App\Repositories\Banha\UserRepository;
use App\Repositories\Banha\WalletHistoryRepository;
use App\Repositories\Banha\WalletRepository;
use App\Traits\Firebase;

class PointsTransferRequestService
{
    use Firebase;
    public function __construct(private PointsTransferRequestRepository $repository, protected WalletRepository $walletRepository, protected WalletHistoryRepository $walletHistoryRepository,
                                protected AppSettingsRepository $appSettingsRepository, protected UserRepository $userRepository, protected NotificationRepository $notificationRepository)
    {

    }

    public function updatePointsTransferRequestStatus($id, $data)
    {
        $appSettings = $this->appSettingsRepository->first();
        $pointPrice = 0.0;
        if (isset($appSettings)) {
            $pointPrice = $appSettings->point_price;
        }
        $obj = $this->find($id);
        $user = $this->userRepository->find($obj->user_id);
        if ($data['status'] == 'accepted') {
            $this->update($id, $data);
            $user->update([
                'points' => $user->points - $obj->points,
            ]);
            $this->walletHistoryRepository->store([
                'user_id' => $data['user_id'],
                'operation' => WalletOperationEnum::TransferPoints->value,
                'status' => WalletStatusEnum::Success->value,
                'amount' => $obj->points * $pointPrice,
            ]);
            $this->walletRepository->store([
                'user_id' => $data['user_id'],
                'status' => WalletStatusEnum::Success->value,
                'amount' => $obj->points * $pointPrice,
            ]);
            $title = 'تم قبول طلب التحويل';
            $message = 'تم قبول طلب التحويل النقاط بنجاح , يرجي التحقق من محفظتك';
            $this->notificationRepository->store([
                'to_user_id' => $data['user_id'],
                'to_user_table' => 'users',
                'title' => $title,
                'message' => $message,
                'action' => NotificationTypesEnum::ApprovePointTransfer->action(),
                'operation_id' => $id,
            ]);
            $this->sendMessage((string)$data['user_id'], $title, $message, [
                'notification_type' => NotificationTypesEnum::ApprovePointTransfer->action(),
            ]);
        } elseif ($data['status'] == 'refused') {
            $this->update($id, $data);
            $title = 'تم رفض طلب التحويل';
            $message = 'تم رفض طلب التحويل النقاط  , يرجي التحقق من محفظتك';
            $this->notificationRepository->store([
                'to_user_id' => $data['user_id'],
                'to_user_table' => 'users',
                'title' => $title,
                'message' => $message,
                'action' => NotificationTypesEnum::RefusePointTransfer->action(),
                'operation_id' => $id,
            ]);
            $this->sendMessage((string)$data['user_id'], $title, $message, [
                'notification_type' => NotificationTypesEnum::RefusePointTransfer->action(),
            ]);
        }
        return true;
    }

    public function pointsTransferRequest($user)
    {
        if ($user->points == 0.0) {
            return ['error' => __("api.this_user_has_not_points")];
        }
        $title = 'تم  طلب التحويل';
        $message = 'تم طلب التحويل النقاط بنجاح , يرجي انتظار موافقة او رفض ادار ةالتطبيق';

        $obj = $this->store([
            'user_id' => $user->id,
            'status' => PointsTransferRequestStatusEnum::Pending->value,
            'points' => $user->points,
        ]);
        $this->notificationRepository->store([
            'to_user_id' => $user->id,
            'to_user_table' => 'users',
            'title' => $title,
            'message' => $message,
            'action' => NotificationTypesEnum::PointTransferRequest->action(),
            'operation_id' => $obj->id,
        ]);
        $this->sendMessage((string)$user->id, $title, $message, [
            'notification_type' => NotificationTypesEnum::PointTransferRequest->action(),
        ]);
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

}
