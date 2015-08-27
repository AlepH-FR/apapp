<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class MatchHistory extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "match_history";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/matchlist";
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
     */
    public function getAvailableMethods() 
    { 
        return [
    		"by_summoner" => new Method($this, "by-summoner/{summonerId}"),
    	];
    }
}