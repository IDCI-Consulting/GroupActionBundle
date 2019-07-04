<?php

namespace IDCI\Bundle\GroupActionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('idci_group_action');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('enable_confirmation')
                    ->defaultTrue()
                ->end()
                ->arrayNode('namespaces')
                    ->defaultValue(array())
                    ->useAttributeAsKey('namespace')
                    ->prototype('array')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
