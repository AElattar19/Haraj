<?php

namespace App\Support\Actions;

use App\Models\User;

class FCMAction
{
    protected array $firebaseToken = [];

    protected string $messageType = 'default';

    protected array $data = ['fcmData' => 'Start data'];

    public function __construct(User $user)
    {
        $this->firebaseToken = $user?->deviceTokens()?->pluck('token')->toArray();
    }

    public function data(array $array): static
    {
        foreach ($array as $k => $v) {
            $this->data[$k] = $v;
        }

        return $this;
    }

    public function messageType(string $messageType): static
    {
        $this->messageType = $messageType;

        return $this;
    }

    public function send($title, $body, $image = '')
    {
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY',
            'AAAAnr3yfXM:APA91bFQDu_lpz9pU2vG6GBoLgBjOFcKtxuFlCo7Vx-cmwZlxjp6wWGJIGRD8O9qW4jMH78IbLMg4trhfBVuYTee2QX3vin3MwKhJcDf6BHzIsui2nTVOGxwP0Qmv8OAZDKV4HlvMUDm');
        $data_array = [
            'registration_ids' => $this->firebaseToken,
            'notification'     => [
                'title' => $title,
                'body'  => $body,
                'image' => $image,
                //"icon" => $icon,
                //"click_action" => $url,
            ],
            'data'             => $this->data,
            'messageType'      => $this->messageType,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key='.$SERVER_API_KEY,
            'Content-Type: application/json',
        ]);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));

        $response = curl_exec($ch);
        curl_close($ch);
    }
}
