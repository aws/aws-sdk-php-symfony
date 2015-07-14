<?php

namespace Aws\Symfony\DependencyInjection;

use Aws;
use Aws\ClientResolver;
use Aws\Sdk;
use ReflectionClass;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('aws', 'variable');

        return $treeBuilder;
    }
}
