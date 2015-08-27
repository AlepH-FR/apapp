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
		return "status";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "shards";
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
            "list"        => new Method($this, ""),
            "by_region"   => new Method($this, "{region}"),
    	];
    }
}