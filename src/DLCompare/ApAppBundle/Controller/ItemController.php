<?php

namespace DLCompare\ApAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DLCompare\ApAppBundle\Stats\ItemStats;

class ItemController extends Controller
{
    /**
     * @Route("/items/list", name="item_list")
     * @Template()
     */
    public function listAction()
    {
        $repo  = $this->get('lolapi.manager.item');
        $items = $repo->findBy([], ['name' => 'ASC']);

        $types = [];
        foreach($items as $item)
        {
            $tags = explode(',', $item->getTags());
            foreach($tags as $tag)
            {
                if(trim($tag) && !in_array($tag, $types))
                {
                    $types[] = $tag;
                }
            }

            $stats[$item->getId()] = new ItemStats($item, $this->get('service_container'));
        }
        sort($types);
        
        return [
            'types' => $types,
            'items' => $items,
            'stats' => $stats,
        ];
    }

    /**
     * @Route("/items/{id}/details", name="item_details")
     * @Template()
     */
    public function detailsAction($id)
    {
        $repo   = $this->get('lolapi.manager.item');
        $item   = $repo->findOneById($id);
        $stats  = new ItemStats($item, $this->get('service_container'));

        try
        {
            $next = $this->get('lolapi')->setRegion('na')->call('static_data', 'item_details', ['id' => $item->getDistantId()], ['version' => '5.14.1', 'itemData' => "all"]);
            $prev = $this->get('lolapi')->setRegion('na')->call('static_data', 'item_details', ['id' => $item->getDistantId()], ['version' => '5.11.1', 'itemData' => "all"]);
        }
        catch(\Exception $e)
        {
            if(!isset($next)) { $next = false; }
            if(!isset($prev)) { $prev = false; }
        }
        return [
            'champions'=> $stats->getMainChampions(),
            'item'     => $item,
            'stats'    => $stats,
            'data'     => [
                '511' => $prev,
                '514' => $next,
            ]
        ];
    }
}
