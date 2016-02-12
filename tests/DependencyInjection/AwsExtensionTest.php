<?php

namespace Aws\Symfony\DependencyInjection;

use AppKernel;
use Aws\AwsClient;
use Aws\Sdk;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

class AwsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    /**
     * @test
     */
    public function sdk_should_be_accessible_as_a_service()
    {
        $this->assertTrue($this->container->has('aws_sdk'));
    }

    /**
     * @test
     * @dataProvider serviceProvider
     *
     * @param string $webServiceName
     * @param string $containerServiceName
     * @param string $clientClassName
     */
    public function all_web_services_in_sdk_manifest_should_be_accessible_as_container_services(
        $webServiceName,
        $containerServiceName,
        $clientClassName
    ) {
        $this->assertTrue(
            $this->container->has($containerServiceName)
        );

        $service = $this->container->get($containerServiceName);
        $this->assertInstanceOf($clientClassName, $service);
        $this->assertInstanceOf(AwsClient::class, $service);
    }

    /**
     * @test
     * @dataProvider serviceRegionProvider
     *
     * @param string $serviceName
     * @param string $serviceRegion
     */
    public function sdk_config_should_be_passed_directly_to_the_constructor_and_resolved_by_the_sdk(
        $serviceName,
        $serviceRegion
    ) {
        $service = $this->container->get($serviceName);

        $this->assertSame($serviceRegion, $service->getRegion());
    }

    /**
     * @test
     */
    public function extension_should_escape_strings_that_begin_with_at_sign()
    {
        $extension = new AwsExtension;
        $config = ['credentials' => [
            'key' => '@@key',
            'secret' => '@@secret'
        ]];
        $container = $this->getMock(ContainerBuilder::class, ['getDefinition', 'replaceArgument']);
        $container->expects($this->once())
            ->method('getDefinition')
            ->with('aws_sdk')
            ->willReturnSelf();
        $container->expects($this->once())
            ->method('replaceArgument')
            ->with(0, $this->callback(function ($arg) {
                return is_array($arg)
                    && isset($arg['credentials'])
                    && $arg['credentials'] === [
                        'key' => '@key',
                        'secret' => '@secret'
                    ];
            }));

        $extension->load([$config], $container);
    }

    /**
     * @test
     */
    public function extension_should_expand_service_references()
    {
        $extension = new AwsExtension;
        $config = ['credentials' => '@aws_sdk'];
        $container = $this->getMock(ContainerBuilder::class, ['getDefinition', 'replaceArgument']);
        $container->expects($this->once())
            ->method('getDefinition')
            ->with('aws_sdk')
            ->willReturnSelf();
        $container->expects($this->once())
            ->method('replaceArgument')
            ->with(0, $this->callback(function ($arg) {
                return is_array($arg)
                    && isset($arg['credentials'])
                    && $arg['credentials'] instanceof Reference
                    && (string) $arg['credentials'] === 'aws_sdk';
            }));

        $extension->load([$config], $container);
    }

    public function serviceProvider()
    {
        $services = [];

        foreach (array_column(\Aws\manifest(), 'namespace') as $serviceNamespace) {
            $clientClass = "Aws\\{$serviceNamespace}\\{$serviceNamespace}Client";
            $services []= [
                $serviceNamespace,
                'aws.' . strtolower($serviceNamespace),
                class_exists($clientClass) ? $clientClass : AwsClient::class,
            ];
        }

        return $services;
    }

    public function serviceRegionProvider()
    {
        $kernel = new AppKernel('test', false);
        $config = $kernel->getTestConfig()['aws'];

        return array_map(
            function (array $service) use ($config) {
                return [
                    $service[1],
                    isset($config[$service[0]]['region']) ?
                        $config[$service[0]]['region']
                        : $config['region']
                ];
            },
            $this->serviceProvider()
        );
    }
}
