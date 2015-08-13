<?php

namespace DLCompare\ApAppBundle\Stats;

use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChampionStats
{
	protected $champion;

	protected $container; 

	public function __construct(Champion $champion, ContainerInterface $container)
	{
		$this->champion  = $champion;
		$this->container = $container;
	}

    public function getPickRate($version)
    {
    	$totalPicks		= $this->container->get('lolapi.manager.participant')->countByVersion($version);
    	$championPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
        
        return ($totalPicks == 0)
    		? 0
    		: number_format(100 * $championPicks / $totalPicks, 2);
    }

    public function getBanRate($version)
    {
    	$totalBans		= $this->container->get('lolapi.manager.game')->countBansByBersion($version);
    	$championBans	= $this->container->get('lolapi.manager.game')->countBansByVersionByChampion($version, $this->champion);
        
        return ($totalBans == 0)
    		? 0
    		: number_format(100 * $championBans / $totalBans, 2);
    }

    public function getUsage($version)
    {
    	return $this->getBanRate($version) + $this->getPickRate($version);
    }

    public function getWinRate($version)
    {
    	$championPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
    	$wins			= $this->container->get('lolapi.manager.participant')->countByVersionByChampionByWin($version, $this->champion);

        return ($championPicks == 0)
    		? 0
    		: number_format(100 * $wins / $championPicks, 2)
    	;
    }

    public function getKillsAverage($version)
    {
    	$championPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
    	$kills          = $this->container->get('lolapi.manager.participant')->countKillsByVersionByChampion($version, $this->champion);

        return ($championPicks == 0)
    		? 0
    		: number_format($kills / $championPicks, 2)
    	;
    }

    public function getDeathsAverage($version)
    {
    	$championPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
    	$deaths         = $this->container->get('lolapi.manager.participant')->countDeathsByVersionByChampion($version, $this->champion);
    	
        return ($championPicks == 0)
    		? 0
    		: number_format($deaths / $championPicks, 2)
    	;
    	
    }

    public function getAssistsAverage($version)
    {
    	$championPicks	= $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
    	$assists        = $this->container->get('lolapi.manager.participant')->countAssistsByVersionByChampion($version, $this->champion);
    	
        return ($championPicks == 0)
    		? 0
    		: number_format($assists / $championPicks, 2)
    	;
    }

    public function getKda($version)
    {
    	$kda = ($this->getDeathsAverage($version) == 0)
			? 0
			: ($this->getKillsAverage($version) + $this->getAssistsAverage($version)) / $this->getDeathsAverage($version);

    	return number_format($kda, 2);
    }

    public function getGold($version)
    {
    	return $this->container->get('lolapi.manager.participant')->getGoldPerMinute($version, $this->champion);  	
    }

    public function getMainItems()
    {
        $items = $this->container->get('lolapi.manager.item')->getMainItems($this->champion, 12);

        usort($items, function($a, $b)
        {
            return $a->getName() > $b->getName();
        });

        return $items;
    }

    public function getItemUsage($version, Item $item)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByChampion($version, $this->champion);
        $useCount       = $this->container->get('lolapi.manager.item')->getUsage($this->champion, $version, $item);

        return ($championPicks == 0)
            ? 0
            : number_format(100 * $useCount / $championPicks, 2)
        ;
    }

    public function getCommonBuild($version, $start = 40, $end = 1000)
    {
        $participant = $this->container->get('lolapi.manager.participant')->getCommonBuild($this->champion, $version, $start, $end);
        return $participant->getItems();
    }
}