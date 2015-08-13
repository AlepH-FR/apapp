<?php

namespace DLCompare\ApAppBundle\Stats;

class ChampionStats
{
	public function __construct(Champion $champion, ContainerInterface $container)
	{

	}
    public function getPickRate($version)
    {
        
    }

    public function getBanRate($version)
    {
        return 50;
    }
}