<?php

namespace App\Services\Banha;

use App\Repositories\Banha\PhoneCodeRepository;
use App\Repositories\Banha\UserRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class PhoneCodeService
{
    public function __construct(private PhoneCodeRepository $repository, private UserRepository $userRepository)
    {

    }

    public function sendCode($data)
    {
        $obj = $this->repository->getWhereFirst(['phone' => $data['phone']]);
//        $data['code'] = rand(10000, 99999);
        $data['code'] = '12345';
        $message = " أهلاً بك في Farouk Mart!\nرمز التحقق الخاص بك هو: {$data['code']}\nيرجى استخدامه لإتمام عملية التسجيل.\nشكرًا لتسوقك معنا 🛒";
        $this->sendSms('20' . $data['phone'], $message);
        if ($obj) {
            return $obj->update($data);
        } else {
            return $this->store($data);
        }
    }

    public function confirmCode($data)
    {
        $obj = $this->repository->getWhereFirst(['phone_code' => $data['phone_code'], 'phone' => $data['phone']]);
        if ($obj) {
            if ($obj->code == $data['code']) {
                $user = $this->checkIfUserExistWithPhone($data);
                if (!$user) {
                    $user = $this->userRepository->store($data);
                    Auth::guard('api')->login($user);
                    $token = $this->generateToken();
                    $user->token = $token;
                    return $user;
                }
                Auth::guard('api')->login($user);
                $token = $this->generateToken();
                $user->token = $token;
                return $user;
            } else {
                return ['error' => __("api.the_code_is_wrong")];
            }
        } else {
            return ['error' => __("api.the_phone_is_wrong")];
        }

    }

    public function checkIfUserExistWithPhone($data)
    {
        return $this->userRepository->getWhereFirst(['phone_code' => $data['phone_code'], 'phone' => $data['phone'], 'is_deleted' => 0, 'is_blocked' => 0]);
    }

    public function generateToken()
    {
        $user = auth('api')->user();
        $token = JWTAuth::fromUser($user);
        return $token;
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

    function sendSms($to, $message, $sender = 'Farouk Mart')
    {
        $client = new Client([
            'base_uri' => 'https://bulk.whysms.com/api/v3/',
            'timeout' => 15.0,
            'verify' => false,
        ]);
        $payload = [
            'sender_id' => $sender,
            'recipient' => $to,
            'message' => $message,
        ];
        try {
            $response = $client->post('sms/send', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer 487|HtI35NItVfFQ64lJBn7Kddl2LNqIiDxmAb0UKOeZfb62ff07',
                ],
                'json' => $payload
            ]);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                dd($e->getResponse()->getBody()->getContents());
            }
            dd($e->getMessage());
        }
    }

}
