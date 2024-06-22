<?php

namespace Xanak\Controller;

use Xanak\Exception\ExceptionHandler;

abstract class BaseController
{

    public function __construct()
    {
        // ExceptionHandler::register();
        set_exception_handler([ExceptionHandler::class, 'handleException']);
        set_error_handler([ExceptionHandler::class, 'handleError']);
    }
    protected function view($template, $data = [])
    {
        extract($data);
        require __DIR__ . "/../../../templates/{$template}.php";
        // try{
        // } catch (\Exception $exception) {
        //     ExceptionHandler::handle($exception);
        // }
    }
}
