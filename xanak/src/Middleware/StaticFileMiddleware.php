<?php

namespace Xanak\Middleware;

class StaticFileMiddleware
{
    protected $resourcePath;

    public function __construct($resourcePath)
    {
        $this->resourcePath = realpath($resourcePath);
    }

    // Handle static files
    public function handle($requestUri)
    {
        $requestedFile = $this->resourcePath . $requestUri . 'css\\style.css';
        if(chmod($requestedFile, 0755)){

            if ($requestedFile && file_exists($requestedFile) && strpos(realpath($requestedFile), $this->resourcePath) === 0) {
                $mimeType = mime_content_type($requestedFile);
                header('Content-Type: ' . $mimeType);
                readfile($requestedFile);
                exit;
            }else{
                header("HTTP/1.0 404 Not Found");
                echo "404 Not Found";
            }
        } else{
            echo ('not given the permissions');
        }
    }
}
