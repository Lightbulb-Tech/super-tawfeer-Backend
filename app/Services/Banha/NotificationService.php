<?php

namespace App\Services\Banha;

use App\Enums\NotificationTypesEnum;
use App\Repositories\Banha\NotificationRepository;
use App\Repositories\Banha\UserRepository;
use App\Traits\Firebase;

class NotificationService
{
    use Firebase;

    public function __construct(private NotificationRepository $repository, private UserRepository $userRepository)
    {

    }

    public function storeGeneralNotification($dataInsert, $admin_id): array
    {
        $recipients = [];
        switch ($dataInsert['recipient_type']) {
            case "specific_users":
                $recipients = isset($dataInsert['user_id']) && is_array($dataInsert['user_id'])
                    ? $dataInsert['user_id']
                    : [];
                break;
            case "all_users":
                $recipients = $this->userRepository->getWhere([ 'is_blocked' => 0])->pluck("id")->toArray();
                break;
        }
//        if (count($recipients) >= 50) {
//            foreach ($recipients as $recipientId) {
//                SendGeneralNotificationJob::dispatch($recipientId, $admin_id, $dataInsert);
//                $this->sendMessage($dataInsert['to_user_id'], $dataInsert['title'], $dataInsert['message'], [
//                    'notification_type' => NotificationEnum::General->action(),
//                ]);
//            }
//        } else {
        foreach ($recipients as $recipientId) {
            $dataInsert['to_user_id'] = (string)$recipientId;
            $dataInsert['form_user_id'] = (string)$admin_id;
            $dataInsert['form_user_table'] = 'admins';
            $dataInsert['to_user_table'] = 'users';
            $dataInsert['action'] = NotificationTypesEnum::General->action();
            $this->store($dataInsert);
            $this->sendMessage($dataInsert['to_user_id'], $dataInsert['title'], $dataInsert['message'], [
                'notification_type' => NotificationTypesEnum::General->action(),
            ]);
        }
//        }
        return ['message' => 'Notifications are being processed in the background.'];
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

    public function getWhereWithoutGet($where)
    {
        return $this->repository->getWhereWithoutGet($where);
    }

    public function getWhereWithPagination($where)
    {
        return $this->repository->getWhereWithPagination($where);
    }

}
