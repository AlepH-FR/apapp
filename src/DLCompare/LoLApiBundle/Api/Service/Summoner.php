<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Summoner extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "summoner";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/summoner";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.4";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
        return [
            "search"    => new Method($this, "by-name/{summonerNames}"),
            "details"   => new Method($this, "{summonerIds}"),
            "masteries" => new Method($this, "{summonerIds}/masteries"),
            "name"      => new Method($this, "{summonerIds}/name"),
            "runes"     => new Method($this, "{summonerIds}/runes"),
    	];
    }
}