<?php

namespace DLCompare\LoLApiBundle\Importer;

use Doctrine\ORM\EntityManager;
use DLCompare\LoLApiBundle\Api\Api;

class ChampionImporter implements ImporterInterface
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
    static protected $champions;

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
     * Calls the api for information about this champion and creates entity.
     * Using static cache to be sure we don't add a champion twice.
     *
     * @param array $variables
     * @return object 
     */
    public function import(array $variables)
    {
    	$championId  = $variables['championId'];
        $region      = $variables['region'];

        if(!isset(self::$champions[$championId]))
        {
            $this->api->setRegion($region);
        	$data = $this->api->call('static_data', 'champion_details', ['id' => $championId], ['champData' => "all"]);

            $champion_class = $this->factory->getEntityClass('champion');
        	$champion = new $champion_class();
        	$champion
        		->setDistantId($data->id)
                ->setName($data->name)
                ->setTitle($data->title)
                ->setImage($data->image->full)
                ->setTags(implode(',', $data->tags))
            ;

        	$this->em->persist($champion);
            self::$champions[$championId] = $champion;
        }

        return self::$champions[$championId];
    }
}