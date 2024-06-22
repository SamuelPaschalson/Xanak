<?php

namespace Xanak\Middleware;

class MiddlewareManager
{
    protected $middlewares = [];

    public function add($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle($request)
    {
        foreach ($this->middlewares as $middleware) {
            call_user_func($middleware, $request);
        }
    }
}
