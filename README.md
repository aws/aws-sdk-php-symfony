# AWS Service Provider for Symfony

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://travis-ci.org/aws/aws-sdk-php-symfony.svg)](https://travis-ci.org/aws/aws-sdk-php-symfony)
[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-symfony/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-symfony)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-symfony/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-symfony)

A Symfony bundle for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS bundle can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-symfony` package in your project's `composer.json`:

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

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Symfony website](http://symfony.com/)
