<?php

namespace DLCompare\LoLApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DLCompareLoLApiExtension extends Extension
{
    public static function getRepository($em, $class)
    {
        return $em->getRepository($class);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dlcompare_lolapi.api.key', $config['api']['key']);
        $container->setParameter('dlcompare_lolapi.api.cache', $config['api']['cache']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if($config['database'] == "orm")
        {
            $loader->load('model.yml');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'dlcompare_lolapi';
    }
}
