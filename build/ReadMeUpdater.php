<?php

namespace Aws\Symfony;

use Composer\Script\Event;
use Symfony\Component\DependencyInjection\Container;

class ReadMeUpdater
{
    const SERVICES_TABLE_START = '<!-- BEGIN SERVICE TABLE -->';
    const SERVICES_TABLE_END = '<!-- END SERVICE TABLE -->';
    const SERVICE_CLASS_DELIMITER = '@CLASS@';
    const DOCS_URL_TEMPLATE = 'http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-@CLASS@.html';

    protected $projectRoot;

    public static function updateReadMe(Event $e)
    {
        $vendorDir = $e->getComposer()->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendorDir);

        require "$vendorDir/autoload.php";

        (new static($projectRoot))->doUpdateReadMe();
    }

    public function __construct($projectRoot = '..')
    {
        $this->projectRoot = $projectRoot;
    }


    protected function doUpdateReadMe()
    {
        $readMeParts = $this->getReadMeWithoutServicesTable();
        $servicesTable = self::SERVICES_TABLE_START . "\n"
            . $this->getServicesTable()
            . self::SERVICES_TABLE_END;

        $updatedReadMe = implode($servicesTable, $readMeParts);
        file_put_contents($this->getReadMePath(), $updatedReadMe);
    }

    protected function getReadMeWithoutServicesTable()
    {
        $readMe = file_get_contents($this->getReadMePath());
        $tablePattern = '/' . preg_quote(self::SERVICES_TABLE_START)
            . '.*' . preg_quote(self::SERVICES_TABLE_END) . '/s';

        return preg_split($tablePattern, $readMe, 2);
    }

    protected function getReadMePath()
    {
        return $this->projectRoot . '/README.md';
    }

    protected function getServicesTable()
    {
        $table = "Service | Instance Of\n--- | ---\n";

        $container = $this->getContainer();
        foreach ($this->getAWSServices($container) as $service) {
            $serviceClass = get_class($container->get($service));
            $apiDocLink = preg_replace(
                '/' . preg_quote(self::SERVICE_CLASS_DELIMITER) . '/',
                str_replace('\\', '.', $serviceClass),
                self::DOCS_URL_TEMPLATE
            );

            $table .= "$service | [$serviceClass]($apiDocLink) \n";
        }

        return $table;
    }

    protected function getAWSServices(Container $container)
    {
        return array_filter($container->getServiceIds(), function ($service) {
            return strpos($service, 'aws') === 0;
        });
    }

    /**
     * @return Container
     */
    protected function getContainer()
    {
        static $container = null;

        if (empty($container)) {
            require_once $this->projectRoot . '/tests/fixtures/AppKernel.php';
            $kernel = new \AppKernel('test', true);
            $kernel->boot();
            $container = $kernel->getContainer();
        }

        return $container;
    }
}