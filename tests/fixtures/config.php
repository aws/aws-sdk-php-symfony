<?php

use Symfony\Component\DependencyInjection\Reference;

$container->loadFromExtension('framework', [
    'secret' =>  'Rosebud was the name of his sled.',
]);

$container->loadFromExtension('aws', [
    'version' => 'latest',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => 'not-a-real-key',
        'secret' => '@@not-a-real-secret', // this will be escaped as '@not-a-real-secret'
    ],
    'DynamoDb' =>[
        'region' => 'us-west-2',
    ],
    'S3' => [
        'version' => '2006-03-01',
    ],
    'Sqs' =>[
        'credentials' => new Reference('a_service'), // '@a_service' would also work in a PHP config
    ],
    'CloudSearchDomain' => [
        'endpoint' => 'http://search-with-some-subdomain.us-east-1.cloudsearch.amazonaws.com',
    ],
]);

$container
    ->register('a_service', 'Aws\\Credentials\\Credentials')
    ->addArgument('a-different-fake-key')
    ->addArgument('a-different-fake-secret');
