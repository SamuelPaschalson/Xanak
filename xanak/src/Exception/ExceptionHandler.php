<?php

namespace Xanak\Exception;

class ExceptionHandler
{
    // public static function handle(\Throwable $e)
    // {
    //     http_response_code(500);
    //     $message = $e->getMessage();
    //     $trace = $e->getTraceAsString();
    //     ob_start();
    //     require __DIR__ . '/error_template.php';
    //     $content = ob_get_clean();
    //     echo $content;
    // }
    public static function handleException($exception) {
        http_response_code(500);
        self::renderError($exception);
    }

    public static function handleError($errno, $errstr, $errfile, $errline) {
        http_response_code(500);
        $error = new \ErrorException($errstr, $errno, 0, $errfile, $errline);
        self::renderError($error);
    }

    public static function renderError($exception) {
        $file = $exception->getFile();
        $line = $exception->getLine();
        $lines = file($file);
        $start = max($line - 5, 0);
        $codeSnippet = array_slice($lines, $start, 10, true);
        require_once __DIR__ . '/error_template.php';
    }
}
