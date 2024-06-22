<?php

namespace Xanak\Logger;

class Logging
{
    public function log($message, $level = 'info')
    {
        $filePath = __DIR__ . '/../../storage/logs/app.log';
        $time = date('Y-m-d H:i:s');
        file_put_contents($filePath, "[$time] [$level] $message\n", FILE_APPEND);
    }
}
