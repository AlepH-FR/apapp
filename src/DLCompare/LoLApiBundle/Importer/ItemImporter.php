<?php

namespace DLCompare\LoLApiBundle\Importer;

use Doctrine\ORM\EntityManager;
use DLCompare\LoLApiBundle\Api\Api;

class ItemImporter implements ImporterInterface
{    
	/**
	 * @var DLCompare\LoLApiBundle\Api\Api
	 */
	protected $api;

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * @var ImporterFactory
	 */
	protected $factory;

    /**
     * @var array
     */
    static protected $items;

    /**
     * {@inheritDoc}
     */
    public function __construct(Api $api, EntityManager $em, ImporterFactory $factory)
    {
    	$this->api 		= $api;
    	$this->em  		= $em;
    	$this->factory  = $factory;
    }

    /**
     * Calls the api for information about this item and creates entity.
     * Using static cache to be sure we don't add an item twice.
     *
     * @param array $variables
     * @return object 
     */
    public function import(array $variables)
    {
    	$itemId = $variables['itemId'];
        $region = $variables['region'];
        $version = $variables['version'];

        list($a, $b) = explode('.', $version);
        $version = $a . '.' . $b . '.1';

        if(!isset(self::$items[$itemId]))
        {
            $this->api->setRegion($region);
        	$data = $this->api->call('static_data', 'item_details', ['id' => $itemId], ['itemData' => "all", 'version' => $version]);

            if(!isset($data->tags))   { $data->tags     = []; }
            if(!isset($data->effect)) { $data->effect   = []; }

            $item_class = $this->factory->getEntityClass('item');
        	$item = new $item_class();
        	$item
        		->setDistantId($data->id)
                ->setName($data->name)
                ->setDescription($data->description)
                ->setImage($data->image->full)
                ->setTags(implode(',', $data->tags))
                ->setCost($data->gold->total)
                ->setStats(serialize($data->stats))
                ->setEffects(serialize($data->effect))
            ;

        	$this->em->persist($item);
            self::$items[$itemId] = $item;
        }

        return self::$items[$itemId];
    }
}