# CHANGELOG

## 2.2.2 - 2020-04-08

* Remove magic method call to support linting command

## 2.2.1 - 2020-03-05

* Fix issue with different tree builder interface for different symfony versions

## 2.2.0 - 2020-03-05

* Added optional configuration validation and merging via AWS_MERGE_CONFIG env variable.

## 2.1.0 - 2019-11-25

* Added support for Symfony ~5.0

## 2.0.2 - 2019-11-07

* Mark client service definition as lazy 

## 2.0.1 - 2019-02-26

* Fixed deprecation for symfony/config 4.2+
* Tweaked Readme usage syntax
* Updated travis CI configuration

## 2.0.0 - 2018-01-18

* Added support for Symfony ~4.0
* Updated package type for Symfony Flex support.

## 1.3.0 - 2017-07-12

* Added support for Symfony ~3.0.
* Fixed deprecation warnings being thrown on Symfony >= 2.6.

## 1.0.2 - 2015-09-05

* Removed usage of `setFactory` method to ensure compatibility with 
  `symfony/dependency-injection` ~2.3

## 1.0.1 - 2015-08-11

* Fixed erroneous dependency declaration (bumped requirement on 
  `symfony/dependency-injection` to ~2.6).

## 1.0.0 - 2015-08-05

* Initial release of the AWS Bundle.
* Added Symfony support for v3 of the AWS SDK for PHP.
