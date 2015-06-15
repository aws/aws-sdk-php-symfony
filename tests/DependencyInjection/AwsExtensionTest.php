<?php

namespace Aws\Symfony\DependencyInjection;

use AppKernel;
use Aws\AwsClient;
use Aws\Sdk;
use Doctrine\Common\Inflector\Inflector;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

    public function serviceProvider()
    {
        $services = [];

        $awsRoot = dirname((new ReflectionClass(Sdk::class))->getFileName());
        $manifestFile = implode(DIRECTORY_SEPARATOR, [$awsRoot, 'data', 'manifest.json']);

        $this->assertFileExists($manifestFile);

        $manifest = json_decode(file_get_contents($manifestFile), true);
        $namespaces = array_column($manifest, 'namespace');

        foreach ($namespaces as $serviceNamespace) {
            $clientClass = "Aws\\{$serviceNamespace}\\{$serviceNamespace}Client";
            $services []= [
                $serviceNamespace,
                'aws.' . Inflector::tableize($serviceNamespace),
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
