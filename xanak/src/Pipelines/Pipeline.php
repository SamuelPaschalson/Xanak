<?php

namespace Xanak\Pipelines;

class Pipeline
{
    protected $pipes = [];

    public function pipe($pipe)
    {
        $this->pipes[] = $pipe;
        return $this;
    }

    public function process($initialValue)
    {
        return array_reduce($this->pipes, function ($carry, $pipe) {
            return call_user_func($pipe, $carry);
        }, $initialValue);
    }
}
