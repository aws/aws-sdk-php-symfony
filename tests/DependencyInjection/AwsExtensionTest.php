<?php

namespace Aws\Symfony\DependencyInjection;

use AppKernel;
use Aws\AwsClient;
use Aws\CodeDeploy\CodeDeployClient;
use Aws\Lambda\LambdaClient;
use Aws\S3\S3Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

class AwsExtensionTest extends TestCase
{
    /**
     * @var AppKernel
     */
    protected $kernel;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        $this->kernel = new AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
    }

    /**
     * @test
     */
    public function sdk_config_should_be_passed_directly_to_the_constructor_and_resolved_by_the_sdk()
    {
        $config           = $this->kernel->getTestConfig()['aws'];
        $s3Region         = isset($config['S3']['region']) ? $config['S3']['region'] : $config['region'];
        $lambdaRegion     = isset($config['Lambda']['region']) ? $config['Lambda']['region'] : $config['region'];
        $codeDeployRegion = isset($config['CodeDeploy']['region']) ? $config['CodeDeploy']['region'] : $config['region'];

        $testService = $this->container->get('test_service');

        $this->assertSame($s3Region, $testService->getS3Client()->getRegion());
        $this->assertSame($lambdaRegion, $testService->getLambdaClient()->getRegion());
        $this->assertSame($codeDeployRegion, $testService->getCodeDeployClient()->getRegion());
    }

    /**
     * @test
     *
     */
    public function all_web_services_in_sdk_manifest_should_be_accessible_as_container_services() {
        $testService = $this->container->get('test_service');

        $this->assertInstanceOf(S3Client::class, $testService->getS3Client());
        $this->assertInstanceOf(LambdaClient::class, $testService->getLambdaClient());
        $this->assertInstanceOf(CodeDeployClient::class, $testService->getCodeDeployClient());

        foreach ($testService->getClients() as $client) {
            $this->assertInstanceOf(AwsClient::class, $client);
        }
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
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getDefinition', 'replaceArgument'])
            ->getMock();
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
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getDefinition', 'replaceArgument'])
            ->getMock();
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
}
