<?php

namespace DLCompare\LoLApiBundle\Api\Cache;

use DLCompare\LoLApiBundle\Api\Method;

class FileCache extends AbstractCache implements CacheInterface
{
    /**
     * Get a filename for a given cache entry based on its key.
     *
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @param array $arguments
     * @return string
     */
    protected function getFilename(Method $method, array $arguments)
    {
        $key = $this->getKey($method, $arguments);

        $path = __DIR__ . '/../../../../..' . '/app/cache/' . $key;
        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function has(Method $method, array $arguments)
    {
        $file = $this->getFilename($method, $arguments);
        if(!file_exists($file)) { return false; }

        $mtime = filemtime($file);
        return !$this->isExpired($mtime, $method);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Method $method, array $arguments)
    {
        $file = $this->getFilename($method, $arguments);
        return file_get_contents($file);
    }
    
    /**
     * {@inheritdoc}
     */
    public function set(Method $method, array $arguments, $value)
    {
        $file = $this->getFilename($method, $arguments);
        file_put_contents($file, $value);
        return $this;
    }
}