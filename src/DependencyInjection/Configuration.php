<?php

namespace Aws\Symfony\DependencyInjection;

use Aws;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        // Maintain backwars compatibility, only merge when AWS_MERGE_CONFIG is set
        $mergeConfig = getenv('AWS_MERGE_CONFIG') ?: false;
        $treeType = 'variable';

        if ($mergeConfig) {
            $treeType = 'array';
        }

        // Most recent versions of TreeBuilder have a constructor
        if (\method_exists(TreeBuilder::class, '__construct')) {
            $treeBuilder = new TreeBuilder('aws', $treeType);
        } else { // which is not the case for older versions
            $treeBuilder = new TreeBuilder;
            $treeBuilder->root('aws', $treeType);
        }

        // If not AWS_MERGE_CONFIG, return empty, variable TreeBuilder
        if (!$mergeConfig) {
            return $treeBuilder;
        }

        if (method_exists($treeBuilder, 'root')) {
            $rootNode = $treeBuilder->root('aws');
        } else {
            $rootNode = $treeBuilder->getRootNode();
        }

        // Define TreeBuilder to allow config validation and merging
        $rootNode
            ->ignoreExtraKeys(false)
            ->children()
                ->variableNode('credentials')->end()
                ->variableNode('debug')->end()
                ->variableNode('stats')->end()
                ->scalarNode('endpoint')->end()
                ->variableNode('endpoint_discovery')->end()
                ->arrayNode('http')
                    ->children()
                        ->floatNode('connect_timeout')->end()
                        ->booleanNode('debug')->end()
                        ->booleanNode('decode_content')->end()
                        ->integerNode('delay')->end()
                        ->variableNode('expect')->end()
                        ->variableNode('proxy')->end()
                        ->scalarNode('sink')->end()
                        ->booleanNode('synchronous')->end()
                        ->booleanNode('stream')->end()
                        ->floatNode('timeout')->end()
                        ->scalarNode('verify')->end()
                    ->end()
                ->end()
                ->scalarNode('profile')->end()
                ->scalarNode('region')->end()
                ->integerNode('retries')->end()
                ->scalarNode('scheme')->end()
                ->scalarNode('service')->end()
                ->scalarNode('signature_version')->end()
                ->variableNode('ua_append')->end()
                ->variableNode('validate')->end()
                ->scalarNode('version')->end()
            ->end()
        ;

        //Setup config trees for each of the services
        foreach (array_column(Aws\manifest(), 'namespace') as $awsService) {
            $rootNode
                ->children()
                    ->arrayNode($awsService)
                        ->ignoreExtraKeys(false)
                        ->children()
                            ->variableNode('credentials')->end()
                            ->variableNode('debug')->end()
                            ->variableNode('stats')->end()
                            ->scalarNode('endpoint')->end()
                            ->variableNode('endpoint_discovery')->end()
                            ->arrayNode('http')
                                ->children()
                                    ->floatNode('connect_timeout')->end()
                                    ->booleanNode('debug')->end()
                                    ->booleanNode('decode_content')->end()
                                    ->integerNode('delay')->end()
                                    ->variableNode('expect')->end()
                                    ->variableNode('proxy')->end()
                                    ->scalarNode('sink')->end()
                                    ->booleanNode('synchronous')->end()
                                    ->booleanNode('stream')->end()
                                    ->floatNode('timeout')->end()
                                    ->scalarNode('verify')->end()
                                ->end()
                            ->end()
                            ->scalarNode('profile')->end()
                            ->scalarNode('region')->end()
                            ->integerNode('retries')->end()
                            ->scalarNode('scheme')->end()
                            ->scalarNode('service')->end()
                            ->scalarNode('signature_version')->end()
                            ->variableNode('ua_append')->end()
                            ->variableNode('validate')->end()
                            ->scalarNode('version')->end()
                        ->end()
                    ->end()
                ->end()
            ;
        }

        return $treeBuilder;
    }
}
