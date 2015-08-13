<?php

namespace DLCompare\LoLApiBundle\Api\Cache;

use DLCompare\LoLApiBundle\Api\Method;

interface CacheInterface
{
    /**
     * Check whether the cache has this entry or not
     *
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @param array $arguments
     * @return boolean
     */
    public function has(Method $method, array $arguments);

    /**
     * Get a cache entry
     *
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @param array $arguments
     * @return string
     */
    public function get(Method $method, array $arguments);
    
	/**
     * Sets a new cache entry
     *
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @param array $arguments
     * @param string $value
     * @return CacheInterface
     */
    public function set(Method $method, array $arguments, $value);
}