# AWS Service Provider for Symfony

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://travis-ci.org/aws/aws-sdk-php-symfony.svg)](https://travis-ci.org/aws/aws-sdk-php-symfony)
[![Latest Stable Version](https://img.shields.io/packagist/v/aws/aws-sdk-php-symfony.svg)](https://packagist.org/packages/aws/aws-sdk-php-symfony)
[![Total Downloads](https://img.shields.io/packagist/dt/aws/aws-sdk-php-symfony.svg)](https://packagist.org/packages/aws/aws-sdk-php-symfony)

A Symfony bundle for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

Jump To:
* [Getting Started](_#Getting-Started_)
* [Getting Help](_#Getting-Help_)
* [Contributing](_#Contributing_)
* [More Resources](_#Resources_)

## Getting Started

### Installation

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

### Configuration

By default, configuration is handled by the SDK rather than by the bundle, and
no validation is performed at compile time. Full documentation of the
configuration options available can be read in the [SDK Guide](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html).

If AWS_MERGE_CONFIG environment variable is set to `true`, configuration
validation and merging are enabled. The bundle validates and merges known
configuration options, including for each service.  Additional configuration
options can be included in a single configuration file, but merging will fail
if non-standard options are specified in more than once.

To use a service for any configuration value, use `@` followed by the service
name, such as `@a_service`. This syntax will be converted to a service during
container compilation. If you want to use a string literal that begins with `@`,
you will need to escape it by adding another `@` sign.

When using the SDK from an EC2 instance, you can write `credentials: ~` to use
[instance profile credentials](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html#instance-profile-credentials).
This syntax means that temporary credentials will be automatically retrieved
from the EC2 instance's metadata server. It's also the preferred technique for
providing credentials to applications running on that specific context.

Sample configuration can be found in the `tests/fixtures` folder for [YAML](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.yml), [PHP](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.php), and [XML](https://github.com/aws/aws-sdk-php-symfony/blob/master/tests/fixtures/config.xml).

#### Sample YML Configuration

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

### Usage

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
php bin/console debug:container aws
```

Full documentation on each of the services listed can be found in the [SDK API
docs](http://docs.aws.amazon.com/aws-sdk-php/v3/api/).

## Getting Help

Please use these community resources for getting help. We use the GitHub issues for tracking bugs and feature requests and have limited bandwidth to address them.

* Ask a question on [StackOverflow](https://stackoverflow.com/) and tag it with [`aws-php-sdk`](http://stackoverflow.com/questions/tagged/aws-php-sdk)
* Come join the AWS SDK for PHP [gitter](https://gitter.im/aws/aws-sdk-php)
* Open a support ticket with [AWS Support](https://console.aws.amazon.com/support/home/)
* If it turns out that you may have found a bug, please [open an issue](https://github.com/aws/aws-sdk-php-symfony/issues/new/choose)

This SDK implements AWS service APIs. For general issues regarding the AWS services and their limitations, you may also take a look at the [Amazon Web Services Discussion Forums](https://forums.aws.amazon.com/).

### Opening Issues

If you encounter a bug with `aws-sdk-php-symfony` we would like to hear about it. Search the existing issues and try to make sure your problem doesn’t already exist before opening a new issue. It’s helpful if you include the version of `aws-sdk-php-symfony`, PHP version and OS you’re using. Please include a stack trace and reduced repro case when appropriate, too.

The GitHub issues are intended for bug reports and feature requests. For help and questions with using `aws-sdk-php` please make use of the resources listed in the Getting Help section. There are limited resources available for handling issues and by keeping the list of open issues lean we can respond in a timely manner.

## Contributing

We work hard to provide a high-quality and useful SDK for our AWS services, and we greatly value feedback and contributions from our community. Please review our [contributing guidelines](./CONTRIBUTING.md) before submitting any issues or pull requests to ensure we have all the necessary information to effectively respond to your bug report or contribution.

## Resources

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Symfony website](http://symfony.com/)
