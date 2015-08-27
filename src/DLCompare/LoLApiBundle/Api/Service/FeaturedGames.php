<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class FeaturedGames extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "featured_games";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "observer-mode/rest";
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
     */
    public function getAvailableMethods() 
    { 
        return [
            "list"                  => new Method($this, "featured"),
            "spectator_game_info"   => new Method($this, "consumergetSpectatorGameInfo/{platformId}/{summonerId}"),
    	];
    }
}