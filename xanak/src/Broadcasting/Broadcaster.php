<?php

namespace Xanak\Broadcasting;

use Pusher\Pusher;
class Broadcaster
{
    protected $channels = [];
    protected $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );
    }

    public function channel($channel, $callback)
    {
        $this->channels[$channel] = $callback;
    }

    public function broadcast($channel, $event, $data)
    {
        if (isset($this->channels[$channel])) {
            call_user_func($this->channels[$channel], $event, $data);
        }
    }
}
