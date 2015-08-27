<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class CurrentGame implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "current_game";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "observer-mode/rest/consumer";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.0";
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function getMethod($method_code) 
    { 
    	$methods = [
            "spectator_game_info" => new Method($this, "getSpectatorGameInfo/{platformId}/{summonerId}"),
    	];

    	if(!array_key_exists($method_code, $methods))
    	{
    		throw new \InvalidArgumentException('Unsupported or inexistant method "' . $method_code. '". Known methods : ' . implode(',', array_keys($methods)));
    	}

    	return $methods[$method_code];
    }
}