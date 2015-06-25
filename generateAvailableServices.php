<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/tests/fixtures/AppKernel.php';

$kernel = new AppKernel('test', true);
$kernel->boot();
$container = $kernel->getContainer();

$services = array_filter($container->getServiceIds(), function ($service) {
    return strpos($service, 'aws.') === 0;
});

$readMePath = __DIR__ . '/README.md';
$serviceTableStart = '<!-- BEGIN SERVICE TABLE -->';
$serviceTableEnd = '<!-- END SERVICE TABLE -->';
$readMeSansServicesTable = preg_split(
    '/' . preg_quote($serviceTableStart) . '.*' . preg_quote($serviceTableEnd) . '/s',
    file_get_contents($readMePath),
    2,
    PREG_SPLIT_DELIM_CAPTURE
);

$table = "$serviceTableStart\nService | Instance Of\n--- | ---\n";
$docsUrlTemplate = 'http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-@CLASS@.html';

foreach ($services as $service) {
    $serviceClass = get_class($container->get($service));
    $apiDocLink = preg_replace(
        '/@CLASS@/',
        str_replace('\\', '.', $serviceClass),
        $docsUrlTemplate
    );

    $table .= "$service | [$serviceClass]($apiDocLink) \n";
}

$table .= $serviceTableEnd;

file_put_contents($readMePath, implode($table, $readMeSansServicesTable));
