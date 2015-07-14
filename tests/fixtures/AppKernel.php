<?php

use Aws\Symfony\AwsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Yaml\Yaml;

class AppKernel extends Kernel
{
    private $extension;

    public function __construct($env, $debug, $extension = 'yml')
    {
        $this->extension = $extension;
        parent::__construct($env, $debug);
    }

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new AwsBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getTestConfigFile($this->extension));
    }

    public function getTestConfig()
    {
        return Yaml::parse(file_get_contents($this->getTestConfigFile('yml')));
    }


    private function getTestConfigFile($extension)
    {
        return __DIR__ . '/config.' . $extension;
    }
}
