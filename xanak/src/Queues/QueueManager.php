<?php

namespace Xanak\Queues;

class QueueManager
{
    protected $queue = [];

    public function push($job)
    {
        $this->queue[] = $job;
    }

    public function pop()
    {
        return array_shift($this->queue);
    }
}
