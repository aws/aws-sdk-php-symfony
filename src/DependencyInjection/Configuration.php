<?php

namespace Aws\Symfony\DependencyInjection;

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
        $rootNode = $treeBuilder->root('aws');

        $childrenOfRoot = $rootNode->children();
        $this->addAwsConfigOptions($childrenOfRoot);

        foreach ($this->getAwsServices() as $awsService) {
            $serviceConfig = $childrenOfRoot->arrayNode($awsService)->children();
            $this->addAwsConfigOptions($serviceConfig);
            $serviceConfig->end();
        }

        $childrenOfRoot->end();

        return $treeBuilder;
    }

    public function getAwsServices()
    {
        static $services = [];

        if (empty($services)) {
            $sdkClass = new ReflectionClass(Sdk::class);
            $manifestFile = implode(DIRECTORY_SEPARATOR, [
                dirname($sdkClass->getFileName()),
                'data',
                'manifest.json',
            ]);

            $manifest = json_decode(file_get_contents($manifestFile), true);

            $services = array_column($manifest, 'namespace');
        }

        return $services;
    }


    protected function addAwsConfigOptions(NodeBuilder $nodeBuilder)
    {
        $options = $this->getAwsConfigOptions();

        $nodeTypeFilter = function ($type) {
            return function (array $option) use ($type) {
                return isset($option['valid']) &&
                    1 === count($option['valid']) &&
                    $type === $option['valid'][0];
            };
        };

        foreach (['scalar' => 'string', 'integer' => 'int', 'boolean' => 'bool'] as $nodeType => $valueType) {
            foreach (array_filter($options, $nodeTypeFilter($valueType)) as $nodeName => $nodeManifest) {
                $nodeBuilder->node($nodeName, $nodeType)->end();

                unset($options[$nodeName]);
            }
        }

        foreach ($options as $nodeName => $nodeManifest) {
            $nodeBuilder->variableNode($nodeName)->end();
        }
    }

    protected function getAwsConfigOptions()
    {
        static $args = [];

        if (empty($args)) {
            $clientResolverClass = new ReflectionClass(ClientResolver::class);

            $args = array_filter(
                $clientResolverClass->getStaticProperties()['defaultArgs'],
                function ($arg) {
                    return empty($arg['internal']);
                }
            );
        }

        return $args;
    }
}