<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Match implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "match";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "2.2";
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function getMethod($method_code) 
    { 
    	$methods = [
    		"details" => new Method($this, "match/{matchId}"),
    	];

    	if(!array_key_exists($method_code, $methods))
    	{
    		throw new \InvalidArgumentException('Unsupported or inexistant method "' . $method_code. '". Known methods : ' . implode(',', array_keys($methods)));
    	}

    	return $methods[$method_code];
    }
}