<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class StaticData implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "static_data";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/static-data/{region}/v{version}";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.2";
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function getMethod($method_code) 
    { 
    	$methods = [
    		"item_list" 		=> new Method($this, "item"),
    		"item_details"		=> new Method($this, "item/{id}"),
    		"champion_list" 	=> new Method($this, "champion"),
    		"champion_details"	=> new Method($this, "champion/{id}"),
    	];

    	if(!array_key_exists($method_code, $methods))
    	{
    		throw new \InvalidArgumentException('Unsupported or inexistant method "' . $method_code. '". Known methods : ' . implode(',', array_keys($methods)));
    	}

    	return $methods[$method_code];
    }
}