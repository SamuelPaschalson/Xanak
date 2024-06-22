<?php

namespace Xanak\Security;

class SecurityManager
{
    public function sanitize($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public function validateToken($token)
    {
        // Implement token validation logic
    }
}
