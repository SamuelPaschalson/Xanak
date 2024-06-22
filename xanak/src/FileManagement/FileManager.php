<?php

namespace Xanak\FileManagement;

class FileManager
{
    protected $uploadDir;

    public function __construct()
    {
        $this->uploadDir = __DIR__ . '/../../../storage/uploads';
    }
    // public function upload($file, $destination = null)
    // {
    //     // if ($this->uploadDir) {
    //     //     # code...
    //     // }
    //     $targetFile = $this->uploadDir . '/' . basename($file['name']);
    //     move_uploaded_file($file['tmp_name'], $destination ?? $targetFile);
    //     if ($destination = null) {
    //         # code...
    //         return $targetFile;
    //     } else{
    //         return $file;
    //     }
    // }

    // public function delete($filePath)
    // {
    //     unlink($filePath);
    // }

    public function upload($file)
    {
        $targetFile = $this->uploadDir . '/' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $targetFile);
        return $targetFile;
    }

    public function delete($filename)
    {
        $file = $this->uploadDir . '/' . $filename;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
