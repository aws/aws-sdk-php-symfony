# AWS Service Provider for Symfony

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://travis-ci.org/aws/aws-sdk-php-symfony.svg)](https://travis-ci.org/aws/aws-sdk-php-symfony)
[![Latest Stable Version](https://img.shields.io/packagist/v/aws/aws-sdk-php-symfony.svg)](https://packagist.org/packages/aws/aws-sdk-php-symfony)
[![Total Downloads](https://img.shields.io/packagist/dt/aws/aws-sdk-php-symfony.svg)](https://packagist.org/packages/aws/aws-sdk-php-symfony)

A Symfony bundle for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS bundle can be installed via [Composer](http://getcomposer.org) by 
requiring the`aws/aws-sdk-php-symfony` package in your project's `composer.json`:

```json
{
    "require": {
        "aws/aws-sdk-php-symfony": "~2.0"
    }
}
```

and adding an instance of `Aws\Symfony\AwsBundle` to your application's kernel:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            ...
            new \Aws\Symfony\AwsBundle(),
        ];
    }
    ...
}
```

## Configuration

Configuration is handled by the SDK rather than by the bundle, and no validation
is performed at compile time. Full documentation of the configuration options
available can be read in the [SDK Guide](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html).

To use a service for any configuration value, use `@` followed by the service
name, such as `@a_service`. This syntax will be converted to a service during
container compilation. If you want to use a string literal that begins with `@`,
you will need to escape it by adding another `@` sign.

Sample configuration can be found in the `tests/fixtures` folder for [YAML](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.yml), [PHP](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.php), and [XML](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.xml).

### Sample YML Configuration

The sample configuration which can be placed in `app/config/config.yml` file.

```yaml
framework:
    secret: "Rosebud was the name of his sled."

aws:
    version: latest
    region: us-east-1
    credentials:
        key: not-a-real-key
        secret: "@@not-a-real-secret" # this will be escaped as '@not-a-real-secret'
    DynamoDb:
        region: us-west-2
    S3:
        version: '2006-03-01'
    Sqs:
        credentials: "@a_service"
    CloudSearchDomain:
        endpoint: https://search-with-some-subdomain.us-east-1.cloudsearch.amazonaws.com

services:
    a_service:
        class: Aws\Credentials\Credentials
        arguments:
            - a-different-fake-key
            - a-different-fake-secret
```
## Usage

This bundle exposes an instance of the `Aws\Sdk` object as well as instances of
each AWS client object as services to your symfony application. They are name 
`aws.{$namespace}`, where `$namespace` is the namespace of the service client.
For instance:

Service | Instance Of
--- | ---
aws.dynamodb | Aws\DynamoDb\DynamoDbClient
aws.ec2 | Aws\Ec2\Ec2Client
aws.s3 | Aws\S3\S3Client
aws_sdk | Aws\Sdk

The services made available depends on which version of the SDK is installed. To
view a full list, run the following command from your application's root 
directory:
```
php bin/console debug:container | grep aws
```

Full documentation on each of the services listed can be found in the [SDK API 
docs](http://docs.aws.amazon.com/aws-sdk-php/v3/api/).

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Symfony website](http://symfony.com/)
