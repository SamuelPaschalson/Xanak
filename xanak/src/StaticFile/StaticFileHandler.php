<?php

namespace Xanak\StaticFile;

class StaticFileHandler {
    private $resourcesDir;

    public function __construct($resourcesDir) {
        $this->resourcesDir = rtrim($resourcesDir, '/') . '/';
    }

    public function serve($filePath) {
        $fullPath = $this->resourcesDir . ltrim($filePath, '/');

        if (!file_exists($fullPath)) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $fileInfo = pathinfo($fullPath);
        $extension = strtolower($fileInfo['extension'] ?? '');

        $mimeType = $this->getMimeType($extension);
        if ($mimeType) {
            header('Content-Type: ' . $mimeType);
        }

        readfile($fullPath);
    }

    private function getMimeType($extension) {
        $mimeTypes = [
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'pdf' => 'application/pdf',
            'txt' => 'text/plain',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
