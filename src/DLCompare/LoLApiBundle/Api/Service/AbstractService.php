<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

abstract class AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function getMethod($method_code) 
    { 
        $methods = $this->getAvailableMethods();
    	if(!array_key_exists($method_code, $methods))
    	{
    		throw new \InvalidArgumentException('Unsupported or inexistant method "' . $method_code. '". Known methods : ' . implode(',', array_keys($methods)));
    	}

    	return $methods[$method_code];
    }
    
    /**
     * Get available methods
     *
     * @return array(DLCompare\LoLApiBundle\Api\Method)
     */
    abstract public function getAvailableMethods();
}