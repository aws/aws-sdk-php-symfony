# AWS Service Provider for Symfony

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://travis-ci.org/aws/aws-sdk-php-symfony.svg)](https://travis-ci.org/aws/aws-sdk-php-symfony)
[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-symfony/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-symfony)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-symfony/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-symfony)

A Symfony bundle for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS bundle can be installed via [Composer](http://getcomposer.org) by 
requiring the`aws/aws-sdk-php-symfony` package in your project's `composer.json`:

```json
{
    "require": {
        "aws/aws-sdk-php-symfony": "~1.0"
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

## Usage

This bundle exposes an instance of the `Aws\Sdk` object as well as instances of 
each AWS client object as services to your symfony application. The services
made available depends on which version of the SDK is installed. To view them, 
run the following command from your application's root directory:

```
php app/console container:debug | grep aws
```

Full documentation on each of the services listed can be found in the [SDK API 
docs](http://docs.aws.amazon.com/aws-sdk-php/v3/api/).

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Symfony website](http://symfony.com/)
