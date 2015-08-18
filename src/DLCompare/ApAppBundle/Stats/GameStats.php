<?php

namespace DLCompare\ApAppBundle\Stats;

use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GameStats extends AbstractStats
{
	protected $container; 

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

    public function getCacheId()
    {
        return "game";
    }

    public function _countByVersion($version)
    {
        return $this->container->get('lolapi.manager.game')->countByVersion($version);
    }

    public function _countByRegion($region)
    {
        return $this->container->get('lolapi.manager.game')->countByRegion($region);
    }

    public function _countByVersionByRegion($version, $region)
    {
        return $this->container->get('lolapi.manager.game')->countByVersionByRegion($version, $region);
    }
}
