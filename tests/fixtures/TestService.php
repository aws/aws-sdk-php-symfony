<?php

namespace Aws\Symfony\fixtures;

use Aws\CodeDeploy\CodeDeployClient;
use Aws\Lambda\LambdaClient;
use Aws\S3\S3Client;

class TestService
{
    protected S3Client $s3Client;
    protected LambdaClient $lambdaClient;
    protected CodeDeployClient $codeDeployClient;

    public function __construct(
        S3Client         $s3Client,
        LambdaClient     $lambdaClient,
        CodeDeployClient $codeDeployClient
    )
    {
        $this->s3Client = $s3Client;
        $this->lambdaClient = $lambdaClient;
        $this->codeDeployClient = $codeDeployClient;
    }

    public function getS3Client(): S3Client
    {
        return $this->s3Client;
    }

    public function getLambdaClient(): LambdaClient
    {
        return $this->lambdaClient;
    }

    public function getCodeDeployClient(): CodeDeployClient
    {
        return $this->codeDeployClient;
    }

    public function getClients(): array
    {
        return [
            $this->s3Client,
            $this->lambdaClient,
            $this->codeDeployClient
        ];
    }
}
