<?php

namespace DLCompare\ApAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DLCompare\ApAppBundle\Stats\GameStats;
use DLCompare\ApAppBundle\Stats\ChampionStats;
use DLCompare\ApAppBundle\Stats\TypeStats;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
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
        
        return [
            'types'     => $types,
            'champions' => $champions,
            'stats'     => $stats,
        ];
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return [];
    }

    /**
     * @Route("/analysis", name="analysis")
     * @Template()
     */
    public function analysisAction()
    {
        $repo  = $this->get('lolapi.manager.champion');
        $champions = $repo->findBy([]);

        $types = [];
        foreach($champions as $champion)
        {
            list($tag) = explode(',', $champion->getTags());
            if(!trim($tag)) { continue; }

            if(!in_array($tag, array_keys($types)))
            {
                $types[$tag] = [
                    'name'      => $tag,
                    'champions' => []
                ];
            }
            $types[$tag]['champions'][] = $champion;
        }

        return [
            'total' => $this->get('lolapi.manager.game')->count(),
            'stat'  => new GameStats($this->get('service_container')),
            'types' => $types,
        ];
    }
}
