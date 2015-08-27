<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class Champion extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "champion";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/{region}/v{version}";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.2";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
    	return [
            "list"      => new Method($this, "champion"),
    		"details"   => new Method($this, "champion/{id}"),
    	];
    }
}