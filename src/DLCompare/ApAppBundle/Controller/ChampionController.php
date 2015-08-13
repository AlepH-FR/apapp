<?php

namespace DLCompare\ApAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DLCompare\ApAppBundle\Stats\ChampionStats;

class ChampionController extends Controller
{
    /**
     * @Route("/champions/list", name="champion_list")
     * @Template()
     */
    public function listAction()
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
     * @Route("/champions/{id}/details", name="champion_details")
     * @Template()
     */
    public function detailsAction($id)
    {
        $repo       = $this->get('lolapi.manager.champion');
        $champion   = $repo->findOneById($id);
        $stats      = new ChampionStats($champion, $this->get('service_container'));

        return [
            'items'    => $stats->getMainItems(),
            'champion' => $champion,
            'stats'    => $stats,
        ];
    }
}
