<?php
namespace Aws\Symfony\DependencyInjection;


use AppKernel;
use Symfony\Component\Filesystem\Filesystem;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
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

        $this->assertTrue($kernel->getContainer()->has('aws_sdk'));
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
