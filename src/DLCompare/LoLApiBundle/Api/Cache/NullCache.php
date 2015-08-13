<?php

namespace DLCompare\LoLApiBundle\Api\Cache;

use DLCompare\LoLApiBundle\Api\Method;

class NullCache implements CacheInterface
{
    /**
     * {@inheritdoc}
     */
    public function has(Method $method, array $arguments)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Method $method, array $arguments)
    {
        return "";
    }
    
    /**
     * {@inheritdoc}
     */
    public function set(Method $method, array $arguments, $value)
    {
        return $this;
    }
}