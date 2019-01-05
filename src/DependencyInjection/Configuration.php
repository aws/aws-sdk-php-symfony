<?php

namespace Aws\Symfony\DependencyInjection;

use Aws;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        // Most recent versions of TreeBuilder have a constructor
        if (\method_exists(TreeBuilder::class, '__construct')) {
            $treeBuilder = new TreeBuilder('aws', 'variable');
        } else { // which is not the case for older versions
            $treeBuilder = new TreeBuilder;
            $treeBuilder->root('aws', 'variable');
        }

        return $treeBuilder;
    }
}
