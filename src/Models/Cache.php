<?php

class Cache {
    private static $cacheFolder = 'C:/xampp/htdocs/cache';

    public static function ensureCacheFolderExists(): void {
        if (!file_exists(self::$cacheFolder)) {
            mkdir(self::$cacheFolder, 0777, true);
        }
    }

    public static function write($key, $data): void {
        self::ensureCacheFolderExists();
        $cacheFile = self::getCacheFilePath($key);
        $serializedData = serialize($data);
        file_put_contents($cacheFile, $serializedData);
    }

    public static function read($key) {
        $cacheFile = self::getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $cachedData = file_get_contents($cacheFile);
            return unserialize($cachedData);
        } else {
            return false;
        }
    }

    private static function getCacheFilePath($key): string {
        return self::$cacheFolder . '/' . $key . '.txt';
    }

    public static function resetCache($key = null): void {
        if ($key !== null) {
            $cacheFile = self::getCacheFilePath($key);
            if (file_exists($cacheFile)) {
                unlink($cacheFile);
            }
        } else {
            $files = glob(self::$cacheFolder . '/*.txt');
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }
}
