<?php
namespace Aws\Symfony\DependencyInjection;

use AppKernel;
use Aws\DynamoDb\DynamoDbClient;
use Aws\Lambda\LambdaClient;
use Aws\S3\S3Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class ConfigurationTest extends TestCase
{
    public function setUp()
    {
        (new Filesystem)
            ->remove(implode(DIRECTORY_SEPARATOR, [
                dirname(__DIR__),
                'fixtures',
                'cache',
                'test',
            ]));
    }

    /**
     * @test
     * @dataProvider formatProvider
     *
     * @param string $format
     */
    public function container_should_compile_and_load($format)
    {
        $kernel = new AppKernel('test', true, $format);
        $kernel->boot();

        $testService = $kernel->getContainer()->get('test_service');

        $this->assertInstanceOf(S3Client::class, $testService->getS3Client());
        $this->assertInstanceOf(LambdaClient::class, $testService->getLambdaClient());
        $this->assertNotInstanceOf(DynamoDbClient::class, $testService->getCodeDeployClient());
    }

    public function formatProvider()
    {
        return [
            ['yml'],
            ['php'],
            ['xml'],
        ];
    }
}
