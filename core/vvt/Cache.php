<?php

declare(strict_types=1);

namespace vvt;

class Cache
{
    use TSingleton;

    public function set(string $key, mixed $data, int $lifeTime = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $lifeTime;

        $hash = hash('sha256', $key) . ".txt";
        $dir = CACHE . '/tmp/cache/' . substr($hash, 0, 2) . '/';
        /**
         * Если директории нет → пытаемся создать 
         * → если не смогли создать и она всё ещё не существует → возвращаем ошибку.
         */
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                return false;
            }
        }
        return file_put_contents($dir . $hash, serialize($content), LOCK_EX) !== false;
    }
    public function get(string $key): mixed
    {
        $file = $this->getFile($key);
        if (!file_exists($file)) return false;

        $content = unserialize(file_get_contents($file));
        if(!is_array($content) || !isset($content['end_time'])){
            unlink($file);
            return false;
        }

        if (time() <= $content['end_time']) return $content['data'];

        unlink($file);
        return false;
    }
    public function delete(string $key): bool
    {
        $file = $this->getFile($key);
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }
    private function getFile(string $key):string
    {
        $hash = hash('sha256', $key) . ".txt";
        $dir = CACHE . '/tmp/cache/' . substr($hash, 0, 2) . '/';
        return $dir . $hash;
    }
}
