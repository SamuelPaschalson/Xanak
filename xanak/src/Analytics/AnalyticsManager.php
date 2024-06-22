<?php

namespace Xanak\Analytics;

class AnalyticsManager
{
    public function track($event, $data)
    {
        // Implement tracking logic
    }

    public static function log($event, $data = [])
    {
        // This is a simple example. In a real application, you'd likely log to a file or external service.
        $logData = date('Y-m-d H:i:s') . " - Event: $event - Data: " . json_encode($data) . PHP_EOL;
        file_put_contents(__DIR__ . '/../../..//storage/logs/analytics.log', $logData, FILE_APPEND);
    }
}
