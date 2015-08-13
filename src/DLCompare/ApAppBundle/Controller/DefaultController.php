<?php

namespace DLCompare\ApAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DLCompare\ApAppBundle\Stats\ChampionStats;

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
            $tags = explode(',', $champion->getTags());
            foreach($tags as $tag)
            {
                if(trim($tag) && !in_array($tag, $types))
                {
                    $types[] = $tag;
                }
            }

            $stats[$champion->getId()] = new ChampionStats($champion, $this->get('service_container'));
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
}
