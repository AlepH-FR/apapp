<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Stats extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "stats";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/stats";
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
            "summoner_summary"  => new Method($this, "by-summoner/{summonerId}/summary"),
            "summoner_ranked"   => new Method($this, "by-summoner/{summonerId}/ranked"),
    	];
    }
}