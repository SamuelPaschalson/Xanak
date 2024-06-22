<?php

namespace Xanak\EnvHandler;

use Dotenv\Dotenv;

class EnvLoader
{
    public static function load($data)
    {
        $basePath = $data;
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }
}
