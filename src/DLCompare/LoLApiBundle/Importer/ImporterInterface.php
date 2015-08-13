<?php

namespace DLCompare\LoLApiBundle\Importer;

use Doctrine\ORM\EntityManager;
use DLCompare\LoLApiBundle\Api\Api;

interface ImporterInterface
{   
	/**
	 * Constructor
	 * 
	 * @param DLCompare\LoLApiBundle\Api\Api $api
	 * @param Doctrine\ORM\EntityManager $em
	 * @param ImporterFactory $factory
	 */ 
    public function __construct(Api $api, EntityManager $em, ImporterFactory $factory);

	/**
	 * Import logic mapping json data to entity should be found here
	 * 
	 * @param array $variables
	 */ 
    public function import(array $variables);
}