<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Team extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "team";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/team";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "2.4";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
        return [
            "by_summoner"   => new Method($this, "by-summoner/{summonerIds}"),
            "details"       => new Method($this, "{teamIds}"),
    	];
    }
}