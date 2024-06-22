<?php

namespace Xanak\Routing;

use Xanak\Responses\Response;
use Xanak\Exception\ExceptionHandler;
use Xanak\StaticFile\StaticFileHandler;

use Xanak\Middleware\StaticFileMiddleware;
class Router
{
    // protected $routes = [];

    // public function get($uri, $action)
    // {
    //     $this->addRoute('GET', $uri, $action);
    // }

    // public function post($uri, $action)
    // {
    //     $this->addRoute('POST', $uri, $action);
    // }

    // protected function addRoute($method, $uri, $action)
    // {
    //     $this->routes[] = compact('method', 'uri', 'action');
    // }

    // public function dispatch($method, $uri)
    // {
    //     foreach ($this->routes as $route) {
    //         if ($method === $route['method'] && $uri === $route['uri']) {
    //             list($controller, $method) = $route['action'];
    //             call_user_func([new $controller, $method]);
    //             return;
    //         }
    //     }

    //     http_response_code(404);
    //     echo "404 Not Found";
    // }

    private $routes = [];
    // private $middleware = [];
    protected $middleware;

    public function __construct($resourcesDir) {
        $this->applyCorsMiddleware();
        set_exception_handler([ExceptionHandler::class, 'handleException']);
        set_error_handler([ExceptionHandler::class, 'handleError']);
        $this->middleware = new StaticFileMiddleware($resourcesDir);
    }

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    // public function middleware($middlewares, $callback) {
    //     $this->middleware = $middlewares;
    //     $callback();
    //     $this->middleware = [];
    // }

    private function applyCorsMiddleware() {
        (new \Xanak\CORS\CorsManager())->handle();
    }

    public function handleRequest($requestUri) {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $this->routes[$method][$requestUri] ?? null;
        if ($action) {
            $publicPath = getcwd();
    
            $uri = urldecode(
                $requestUri
            );
            if ($uri !== '/' && file_exists($publicPath.$uri)) {
                // echo $uri;
                // error_log($uri, 1);
                // error_log($publicPath, 1);
                // echo $publicPath;
                return false;
            }
            if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff|woff2|ttf|eot)$/', $uri)) {
                $this->middleware->handle($uri);
            }
            // $this->middleware->handle($requestUri);
            // foreach ($this->middleware as $middleware) {
            //     (new $middleware)->handle();
            // }

            $controller = new $action[0];
            $method = $action[1];
            $controller->$method();
        } else {
            $this->handleNotFound();
        }
    }
    private function handleNotFound() {
        if (strpos($_SERVER['REQUEST_URI'], '/api') === 0) {
            Response::json(['status' => 404, 'message' => 'Not Found'], 404);
        } else {
            set_exception_handler([ExceptionHandler::class, 'handleException']);
            set_error_handler([ExceptionHandler::class, 'handleError']);
            
        }
    }
}
