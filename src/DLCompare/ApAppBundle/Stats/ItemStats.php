<?php

namespace DLCompare\ApAppBundle\Stats;

use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ItemStats extends AbstractStats
{
	protected $item;

	protected $container; 

	public function __construct(Item $item, ContainerInterface $container)
	{
		$this->item      = $item;
		$this->container = $container;
	}

    public function getCacheId()
    {
        return "item-" . $this->item->getId();
    }

    public function _getUsage($version)
    {
    	$totalPicks	= $this->container->get('lolapi.manager.participant')->countByVersion($version);
    	$itemPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByItem($version, $this->item);
        
        return ($totalPicks == 0)
    		? 0
    		: number_format(100 * $itemPicks / $totalPicks, 2);
    }

    public function _getPurchase($version)
    {
        return 100;
    }

    public function getMainChampions()
    {
        $champions = $this->container->get('lolapi.manager.champion')->getMainChampions($this->item, 12);

        usort($champions, function($a, $b)
        {
            return $a->getName() > $b->getName();
        });

        return $champions;
    }

    public function _getChampionUsage($version, Champion $champion)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $champion);
        $useCount       = $this->container->get('lolapi.manager.item')->getUsage($champion, $version, $this->item);

        return ($championPicks == 0)
            ? 0
            : number_format(100 * $useCount / $championPicks, 2)
        ;
    }

}