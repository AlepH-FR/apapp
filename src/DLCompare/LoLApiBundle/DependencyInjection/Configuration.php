<?php

namespace DLCompare\LoLApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dlcompare_lolapi');

        $rootNode
            ->children()
                ->scalarNode('database')
                    ->validate()
                    ->ifNotInArray(array('orm', 'none'))
                        ->thenInvalid('Invalid database choice "%s"')
                    ->end()
                    ->defaultValue('orm')
                ->end()
                ->arrayNode('api')
                    ->children()
                        ->scalarNode('key')
                            ->isRequired()
                        ->end()
                        ->scalarNode('cache')
                            ->defaultValue('DLCompare\\LoLApiBundle\\Api\\Cache\\FileCache')
                        ->end()
                    ->end()
                ->end() 
            ->end()
        ;

        return $treeBuilder;
    }
}
