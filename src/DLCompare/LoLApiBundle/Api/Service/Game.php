<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Game extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "game";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/game";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.3";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
        return [
            "by_summoner" => new Method($this, "by-summoner/{summonerId}/recent"),
    	];
    }
}