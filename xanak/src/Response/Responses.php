<?php

namespace Xanak\Responses;

class Response {
    public static function json($data, $status = 200, $pretty = true) {
        http_response_code($status);
        header('Content-Type: application/json');
        $options = $pretty ? JSON_PRETTY_PRINT : 0;
        echo json_encode($data, $options);
        exit;
    }
}
