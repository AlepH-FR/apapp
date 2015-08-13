<?php

namespace DLCompare\LoLApiBundle\Importer;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ImporterFactory
{    
    /**
     * @var ContainerInterface
     */    
    protected $container;

    /**
     * @var array
     */
    static protected $importers;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
    	$this->container = $container;
    }

    /**
     * Create an importer instance for a specified entity
     * Using static cache for performance purposes
     *
     * @param string $code
     * @return ImporterInterface
     *
     * @throws \InvalidArgumentException
     */
    public function getImporter($code)
    {
        $code = strtolower($code);
        if(!isset(self::$importers[$code]))
        {
            $class = $this->container->getParameter('lolapi.importer.' . $code . '.class');

            if(!$class)
            {
                throw new \InvalidArgumentException('No importer known for entity "' . $code . '"');
            }

            $object = new $class($this->container->get('lolapi'), $this->container->get('doctrine.orm.entity_manager'), $this);
            if(!$object instanceof ImporterInterface)
            {
                throw new \InvalidArgumentException('Importers must implement ImporterInterface');
            }

            self::$importers[$code] = $object;
        }

        return self::$importers[$code];
    }

    /**
     * Get an entity class based on its code
     *
     * @param string $code
     * @return string
     */
    public function getEntityClass($code)
    {
        $code = strtolower($code);
        return $this->container->getParameter('lolapi.entity.' . $code . '.class');
    }
}