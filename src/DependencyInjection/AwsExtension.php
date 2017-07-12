<?php

namespace Aws\Symfony\DependencyInjection;

use Aws;
use Aws\AwsClient;
use Aws\Symfony\AwsBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel;

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
        $this->inflateServicesInConfig($config);

        $container
            ->getDefinition('aws_sdk')
            ->replaceArgument(0, $config + ['ua_append' => [
                'Symfony/' . Kernel::VERSION,
                'SYMOD/' . AwsBundle::VERSION,
            ]]);

        foreach (array_column(Aws\manifest(), 'namespace') as $awsService) {
            $serviceName = 'aws.' . strtolower($awsService);
            $serviceDefinition = $this->createServiceDefinition($awsService);
            $container->setDefinition($serviceName, $serviceDefinition);

            $container->setAlias($serviceDefinition->getClass(), $serviceName);
        }
    }


    private function createServiceDefinition($name)
    {
        $clientClass = "Aws\\{$name}\\{$name}Client";
        $serviceDefinition = new Definition(
            class_exists($clientClass) ? $clientClass : AwsClient::class
        );

        // Handle Symfony >= 2.6
        if (method_exists($serviceDefinition, 'setFactory')) {
            $serviceDefinition->setFactory([
                new Reference('aws_sdk'),
                'create' . $name,
            ]);
        } else {
            $serviceDefinition
                ->setFactoryService('aws_sdk')
                ->setFactoryMethod('create' . $name);
        }

        return $serviceDefinition;
    }

    private function inflateServicesInConfig(array &$config)
    {
        array_walk($config, function (&$value) {
            if (is_array($value)) {
                $this->inflateServicesInConfig($value);
            }

            if (is_string($value) && 0 === strpos($value, '@')) {
                // this is either a service reference or a string meant to
                // start with an '@' symbol. In any case, lop off the first '@'
                $value = substr($value, 1);
                if (0 !== strpos($value, '@')) {
                    // this is a service reference, not a string literal
                    $value = new Reference($value);
                }
            }
        });
    }
}
