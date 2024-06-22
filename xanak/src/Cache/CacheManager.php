<?php

namespace Xanak\Cache;

class CacheManager
{
    protected $cacheDir;

    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../../storage/cache';
    }

    public function get($key)
    {
        $cacheFile = $this->cacheDir . '/' . md5($key) . '.cache';
        if (file_exists($cacheFile)) {
            return unserialize(file_get_contents($cacheFile));
        }
        return null;
    }

    public function set($key, $value, $expiration = 3600)
    {
        $cacheFile = $this->cacheDir . '/' . md5($key) . '.cache';
        file_put_contents($cacheFile, serialize($value));
        touch($cacheFile, time() + $expiration);
    }

    public function clear($key)
    {
        $cacheFile = $this->cacheDir . '/' . md5($key) . '.cache';
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }
}
