<?php

namespace DLCompare\LoLApiBundle\Api;

use DLCompare\LoLApiBundle\Api\Service\ServiceInterface;

/**
 * The Method class is an object mapper for webservices method calls.
 * It enables us to with clean objects rather than associative arrays
 */
class Method
{ 
    /**
     * @var  DLCompare\LoLApiBundle\Api\Service\ServiceInterface
     */
    protected $service;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var  integer|boolean
     */
	protected $cacheMaxAge;
    
    /**
     * Main class constructor. Sets api key
     *
     * @param DLCompare\LoLApiBundle\Api\Service\ServiceInterface $service
     * @param string $suffix
     * @return Method
     */
    public function __construct(ServiceInterface $service, $suffix, $cacheMaxAge = false)
    {
        $this->service = $service;
        $this->suffix  = $suffix;
        $this->cacheMaxAge = $cacheMaxAge;
    } 

    /**
     * Get service using this method
     *
     * @return DLCompare\LoLApiBundle\Api\Service\ServiceInterface
     */
    public function getService()
    {
    	return $this->service;
    }

    /**
     * Get url suffix of this method
     *
     * @return string
     */
    public function getSuffix()
    {
    	return $this->suffix;
    }

    /**
     * Get max duration of any cache for this method
     *
     * @return integer|boolean
     */
    public function getCacheMaxAge()
    {
    	return $this->cacheMaxAge;
    }
}