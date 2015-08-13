<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

interface ServiceInterface
{
	/**
     * Get code of the service which it'll be called by, by the main Api service 
     *
     * @return string
     */
    public function getCode();

	/**
     * Get prefix of the url of the webservice
     *
     * @return string
     */
    public function getPrefix();
    
	/**
     * Get version of the webservice. Mandatory to construct urls
     *
     * @return string
     */
    public function getVersion();
    
	/**
     * Get a method given it's code method
     *
     * @param string $method_code
     * @return DLCompare\LoLApiBundle\Api\Method
     */
    public function getMethod($method_code);
}