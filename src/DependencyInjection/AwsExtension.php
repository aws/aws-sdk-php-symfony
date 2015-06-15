<?php

namespace Aws\Symfony\DependencyInjection;

use Aws\AwsClient;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class AwsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container
            ->getDefinition('aws_sdk')
            ->replaceArgument(0, $config);

        foreach ($configuration->getAwsServices() as $awsService) {
            $container->setDefinition(
                'aws.' . Inflector::tableize($awsService),
                $this->createServiceDefinition($awsService)
            );
        }
    }


    protected function createServiceDefinition($name)
    {
        $clientClass = "Aws\\{$name}\\{$name}Client";
        $serviceDefinition = new Definition(
            class_exists($clientClass) ? $clientClass : AwsClient::class
        );

        $serviceDefinition->setFactory([
            new Reference('aws_sdk'),
            'create' . $name,
        ]);

        return $serviceDefinition;
    }
}