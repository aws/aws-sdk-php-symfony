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
        "aws/aws-sdk-php-symfony": "~0.1"
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

This bundle exposes an instance of the `Aws\Sdk` object as well as instances of each AWS client object as services to your symfony application

<!-- BEGIN SERVICE TABLE -->
Service | Instance Of
--- | ---
aws.autoscaling | [Aws\AutoScaling\AutoScalingClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.AutoScaling.AutoScalingClient.html) 
aws.cloudformation | [Aws\CloudFormation\CloudFormationClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudFormation.CloudFormationClient.html) 
aws.cloudfront | [Aws\CloudFront\CloudFrontClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudFront.CloudFrontClient.html) 
aws.cloudhsm | [Aws\CloudHsm\CloudHsmClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudHsm.CloudHsmClient.html) 
aws.cloudsearch | [Aws\CloudSearch\CloudSearchClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudSearch.CloudSearchClient.html) 
aws.cloudsearchdomain | [Aws\CloudSearchDomain\CloudSearchDomainClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudSearchDomain.CloudSearchDomainClient.html) 
aws.cloudtrail | [Aws\CloudTrail\CloudTrailClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudTrail.CloudTrailClient.html) 
aws.cloudwatch | [Aws\CloudWatch\CloudWatchClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudWatch.CloudWatchClient.html) 
aws.cloudwatchlogs | [Aws\CloudWatchLogs\CloudWatchLogsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CloudWatchLogs.CloudWatchLogsClient.html) 
aws.codecommit | [Aws\CodeCommit\CodeCommitClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CodeCommit.CodeCommitClient.html) 
aws.codedeploy | [Aws\CodeDeploy\CodeDeployClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CodeDeploy.CodeDeployClient.html) 
aws.codepipeline | [Aws\CodePipeline\CodePipelineClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CodePipeline.CodePipelineClient.html) 
aws.cognitoidentity | [Aws\CognitoIdentity\CognitoIdentityClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CognitoIdentity.CognitoIdentityClient.html) 
aws.cognitosync | [Aws\CognitoSync\CognitoSyncClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.CognitoSync.CognitoSyncClient.html) 
aws.configservice | [Aws\ConfigService\ConfigServiceClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.ConfigService.ConfigServiceClient.html) 
aws.datapipeline | [Aws\DataPipeline\DataPipelineClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DataPipeline.DataPipelineClient.html) 
aws.devicefarm | [Aws\DeviceFarm\DeviceFarmClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DeviceFarm.DeviceFarmClient.html) 
aws.directconnect | [Aws\DirectConnect\DirectConnectClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DirectConnect.DirectConnectClient.html) 
aws.directoryservice | [Aws\DirectoryService\DirectoryServiceClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DirectoryService.DirectoryServiceClient.html) 
aws.dynamodb | [Aws\DynamoDb\DynamoDbClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DynamoDb.DynamoDbClient.html) 
aws.dynamodbstreams | [Aws\DynamoDbStreams\DynamoDbStreamsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.DynamoDbStreams.DynamoDbStreamsClient.html) 
aws.ec2 | [Aws\Ec2\Ec2Client](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Ec2.Ec2Client.html) 
aws.ecs | [Aws\Ecs\EcsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Ecs.EcsClient.html) 
aws.efs | [Aws\Efs\EfsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Efs.EfsClient.html) 
aws.elasticache | [Aws\ElastiCache\ElastiCacheClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.ElastiCache.ElastiCacheClient.html) 
aws.elasticbeanstalk | [Aws\ElasticBeanstalk\ElasticBeanstalkClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.ElasticBeanstalk.ElasticBeanstalkClient.html) 
aws.elasticloadbalancing | [Aws\ElasticLoadBalancing\ElasticLoadBalancingClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.ElasticLoadBalancing.ElasticLoadBalancingClient.html) 
aws.elastictranscoder | [Aws\ElasticTranscoder\ElasticTranscoderClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.ElasticTranscoder.ElasticTranscoderClient.html) 
aws.emr | [Aws\Emr\EmrClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Emr.EmrClient.html) 
aws.glacier | [Aws\Glacier\GlacierClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Glacier.GlacierClient.html) 
aws.iam | [Aws\Iam\IamClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Iam.IamClient.html) 
aws.kinesis | [Aws\Kinesis\KinesisClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Kinesis.KinesisClient.html) 
aws.kms | [Aws\Kms\KmsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Kms.KmsClient.html) 
aws.lambda | [Aws\Lambda\LambdaClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Lambda.LambdaClient.html) 
aws.machinelearning | [Aws\MachineLearning\MachineLearningClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.MachineLearning.MachineLearningClient.html) 
aws.opsworks | [Aws\OpsWorks\OpsWorksClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.OpsWorks.OpsWorksClient.html) 
aws.rds | [Aws\Rds\RdsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Rds.RdsClient.html) 
aws.redshift | [Aws\Redshift\RedshiftClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Redshift.RedshiftClient.html) 
aws.route53 | [Aws\Route53\Route53Client](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Route53.Route53Client.html) 
aws.route53domains | [Aws\Route53Domains\Route53DomainsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Route53Domains.Route53DomainsClient.html) 
aws.s3 | [Aws\S3\S3Client](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html) 
aws.ses | [Aws\Ses\SesClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Ses.SesClient.html) 
aws.sns | [Aws\Sns\SnsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sns.SnsClient.html) 
aws.sqs | [Aws\Sqs\SqsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sqs.SqsClient.html) 
aws.ssm | [Aws\Ssm\SsmClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Ssm.SsmClient.html) 
aws.storagegateway | [Aws\StorageGateway\StorageGatewayClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.StorageGateway.StorageGatewayClient.html) 
aws.sts | [Aws\Sts\StsClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sts.StsClient.html) 
aws.support | [Aws\Support\SupportClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Support.SupportClient.html) 
aws.swf | [Aws\Swf\SwfClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Swf.SwfClient.html) 
aws.workspaces | [Aws\WorkSpaces\WorkSpacesClient](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.WorkSpaces.WorkSpacesClient.html) 
aws_sdk | [Aws\Sdk](http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sdk.html) 
<!-- END SERVICE TABLE -->

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Symfony website](http://symfony.com/)
