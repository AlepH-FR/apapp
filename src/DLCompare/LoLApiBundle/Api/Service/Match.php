<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Match extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "match";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}/match";
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
    		"details" => new Method($this, "{matchId}"),
    	];
    }
}