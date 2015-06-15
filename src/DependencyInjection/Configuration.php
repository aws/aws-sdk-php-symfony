<?php

namespace Aws\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('aws');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }
}