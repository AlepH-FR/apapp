<?php

namespace DLCompare\LoLApiBundle\Api\Cache;

use DLCompare\LoLApiBundle\Api\Method;

abstract class AbstractCache implements CacheInterface
{    
    /**
     * Retrieve a cache key given a method and its arguments
     *
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @param array $arguments
     * @return string
     */
    public function getKey(Method $method, array $arguments)
    {
        $key = 'lolapi_';
        $key.= $method->getService()->getPrefix();
        $key.= $method->getSuffix();

        foreach($arguments as $k => $v)
        {
            $key.= "." . $k . "-" . $v;
        }

        $key = str_replace(['/', '{', '}'], ['_','',''], $key);

        return $key;
    }

    /**
     * Check whether a cache has expired or not
     *
     * @param integer $timestamp
     * @param DLCompare\LoLApiBundle\Api\Method $method
     * @return boolean
     */
    public function isExpired($timestamp, Method $method)
    {
        if($method->getCacheMaxAge() === false) { return false; }
        
        $now     = time();
        $expires = $timestamp + $method->getCacheMaxAge();

        return ($now > $expires);
    }
}