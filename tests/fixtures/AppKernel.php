<?php

use Aws\Symfony\AwsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Yaml\Yaml;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new AwsBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getTestConfigFile());
    }

    public function getTestConfig()
    {
        return Yaml::parse(file_get_contents($this->getTestConfigFile()));
    }


    protected function getTestConfigFile()
    {
        return __DIR__ . '/config.yml';
    }
}