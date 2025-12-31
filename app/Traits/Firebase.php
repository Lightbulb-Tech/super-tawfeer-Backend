<?php
namespace App\Traits;

use App\Services\Banha\UserService;
use Google\Auth\Credentials\ServiceAccountCredentials;

trait Firebase
{
    public function sendFCMNotification($token, $title, $message, $notification = [])
    {
        try {
            $accessTokenObject = new ServiceAccountCredentials(['https://www.googleapis.com/auth/firebase.messaging'], public_path('super-tawfeer-02de3643ce12.json'));
            $accessToken = $accessTokenObject->fetchAuthToken()['access_token'];
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ];
            $fcmEndpoint = "https://fcm.googleapis.com/v1/projects/super-tawfeer/messages:send";
            $arr = [
                'title' => $title,
                'body' => $message,
            ];

            $data = $notification;
//             dd($notification);
            $message = [
                "message" => [
                    "token" => $token,
                    "notification" => [
                        "title" => $title,
                        "body" => $message,
                    ],
                    "data" => (object) $notification, // لازم يكون key => value
                    "android" => [
                        "priority" => "high",
                    ],
                    "apns" => [
                        "headers" => [
                            "apns-priority" => "10",
                        ],
                        "payload" => [
                            "aps" => [
                                "sound" => "default",
                            ]
                        ]
                    ]
                ]
            ];
//             dd($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fcmEndpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
//             dd($result);
        }catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function sendMessage($user_id, $title, $message, $notification = [])
    {

        $userService = app(UserService::class);
        $user = $userService->find($user_id);
        foreach ($user->fireBaseTokens as $token) {
            $this->sendFCMNotification($token->token, $title, $message, $notification);
        }
        return true;
    }
}

