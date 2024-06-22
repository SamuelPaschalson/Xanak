<?php

namespace Xanak\Auth;

class AuthManager
{
    public function login($user)
    {
        $_SESSION['user'] = $user;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function user()
    {
        return $_SESSION['user'] ?? null;
    }
}
