<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('openclassrooms_use_case');
        $rootNode->children()
                    ->scalarNode('security')->defaultValue('security_context')->end()
                    ->scalarNode('transaction')->defaultValue('doctrine.orm.entity_manager')->end()
                    ->scalarNode('event_sender')->defaultValue('event_dispatcher')->end()
                    ->scalarNode('event_factory')->defaultValue('openclassrooms.use_case.event_factory')->end()
                  ->end();

        return $treeBuilder;
    }
}
