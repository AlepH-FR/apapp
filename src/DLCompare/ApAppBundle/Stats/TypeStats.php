<?php

namespace DLCompare\ApAppBundle\Stats;

use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Item;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TypeStats extends AbstractStats
{
	protected $tag;

    protected $champions = [];

	protected $container; 

	public function __construct($tag, ContainerInterface $container)
	{
		$this->tag       = $tag;
		$this->container = $container;
	}

    public function getCacheId()
    {
        return "type-" . $this->tag;
    }

    public function _getPickRate($version)
    {
        $totalPicks     = $this->container->get('lolapi.manager.participant')->countByVersion($version);
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByTag($version, $this->tag);
        
        return ($totalPicks == 0)
            ? 0
            : number_format(100 * $championPicks / $totalPicks, 2);
    }

    public function _getBanRate($version)
    {
        $totalBans      = $this->container->get('lolapi.manager.game')->countBansByVersion($version);
        $championBans   = $this->container->get('lolapi.manager.game')->countBansByVersionByTag($version, $this->tag);
        
        return ($totalBans == 0)
            ? 0
            : number_format(100 * $championBans / $totalBans, 2);
    }  

    public function _getWinRate($version)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByTag($version, $this->tag);
        $wins           = $this->container->get('lolapi.manager.participant')->countByVersionByTagByWin($version, $this->tag);

        return ($championPicks == 0)
            ? 0
            : number_format(100 * $wins / $championPicks, 2)
        ;
    }

    public function _getKillsAverage($version)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByTag($version, $this->tag);
        $kills          = $this->container->get('lolapi.manager.participant')->countKillsByVersionByTag($version, $this->tag);

        return ($championPicks == 0)
            ? 0
            : number_format($kills / $championPicks, 2)
        ;
    }

    public function _getDeathsAverage($version)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByTag($version, $this->tag);
        $deaths         = $this->container->get('lolapi.manager.participant')->countDeathsByVersionByTag($version, $this->tag);
        
        return ($championPicks == 0)
            ? 0
            : number_format($deaths / $championPicks, 2)
        ;
        
    }

    public function _getAssistsAverage($version)
    {
        $championPicks  = $this->container->get('lolapi.manager.participant')->countByVersionByTag($version, $this->tag);
        $assists        = $this->container->get('lolapi.manager.participant')->countAssistsByVersionByTag($version, $this->tag);
        
        return ($championPicks == 0)
            ? 0
            : number_format($assists / $championPicks, 2)
        ;
    }

    public function _getKda($version)
    {
        $kda = ($this->getDeathsAverage($version) == 0)
            ? 0
            : ($this->getKillsAverage($version) + $this->getAssistsAverage($version)) / $this->getDeathsAverage($version);

        return number_format($kda, 2);
    }
}
