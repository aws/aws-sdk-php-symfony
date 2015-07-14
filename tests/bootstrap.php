<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/fixtures/AppKernel.php';

$fs = new \Symfony\Component\Filesystem\Filesystem();
$fs->remove(implode(DIRECTORY_SEPARATOR, [
    __DIR__,
    'fixtures',
    'cache',
    'test',
]));
