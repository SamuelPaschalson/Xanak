<?php

namespace Xanak\Session;

class SessionManager
{
    public function start()
    {
        session_start();
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function destroy()
    {
        session_destroy();
    }
}
