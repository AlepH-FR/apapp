<?php

namespace DLCompare\ApAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DLCompare\ApAppBundle\Stats\GameStats;
use DLCompare\ApAppBundle\Stats\ChampionStats;
use DLCompare\ApAppBundle\Stats\TypeStats;
use DLCompare\ApAppBundle\Stats\ItemStats;
use DLCompare\CacheBundle\Configuration\ActionCache;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     * @ActionCache(maxage=5184000)
     */
    public function indexAction()
    {
        $repo  = $this->get('lolapi.manager.champion');
        $champions = $repo->findBy([], ['name' => 'ASC']);

        $types = [];
        $stats = [];
        foreach($champions as $champion)
        {
            $stats[$champion->getId()] = new ChampionStats($champion, $this->get('service_container'));

            $tags = explode(',', $champion->getTags());
            foreach($tags as $tag)
            {
                if(!trim($tag)) { continue; }

                if(!in_array($tag, array_keys($types)))
                {
                    $types[$tag] = [
                        'name'  => $tag,
                        'stats' => new TypeStats($tag, $this->get('service_container'))
                    ];
                }
            }
        }
        sort($types);

        $repo  = $this->get('lolapi.manager.item');
        $items = $repo->findMostExpansive(2500);
        $itemStats = [];
        foreach($items as $item)
        {
            $itemStats[$item->getId()] = new ItemStats($item, $this->get('service_container'));
        }
        
        return [
            'types'     => $types,
            'champions' => $champions,
            'stats'     => $stats,
            'items'     => $items,
            'itemStats' => $itemStats,
        ];
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     * @ActionCache(maxage=5184000)
     */
    public function aboutAction()
    {
        return [];
    }

    /**
     * @Route("/analysis", name="analysis")
     * @Template()
     * @ActionCache(maxage=5184000)
     */
    public function analysisAction()
    {
        $repo  = $this->get('lolapi.manager.champion');
        $champions = $repo->findBy([], ['name' => 'ASC']);

        $types = [];
        foreach($champions as $champion)
        {
            list($tag) = explode(',', $champion->getTags());
            if(!trim($tag)) { continue; }

            if(!in_array($tag, array_keys($types)))
            {
                $types[$tag] = [
                    'name'      => $tag,
                    'stats'     => new TypeStats($tag, $this->get('service_container')),
                    'champions' => []
                ];
            }
            $types[$tag]['champions'][] = $champion;
        }

        $repo  = $this->get('lolapi.manager.item');
        $items = $repo->findMostExpansive(2500);

        return [
            'total' => $this->get('lolapi.manager.game')->count(),
            'stat'  => new GameStats($this->get('service_container')),
            'items' => $items,
            'types' => $types,
        ];
    }
}
