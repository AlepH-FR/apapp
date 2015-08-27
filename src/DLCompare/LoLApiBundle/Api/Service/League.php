<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class League extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "league";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/league";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "2.5";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
        return [
            "by_summoner"   => new Method($this, "by-summoner/{summonerIds}"),
            "by_team"       => new Method($this, "by-team/{teamIds}"),
            "challenger"    => new Method($this, "challenger"),
            "master"        => new Method($this, "master"),
    	];
    }
}