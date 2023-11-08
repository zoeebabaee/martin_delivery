<?php

namespace App\Service;

class Responser
{
    public static function success($data = null, $status=200)
    {
        return [
            'message' => 'messages.success_action_message',
            'status' => $status,
            'data' => $data
        ];
    }
}
