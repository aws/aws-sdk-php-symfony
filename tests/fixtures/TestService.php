<?php

namespace Aws\Symfony\fixtures;

use Aws\CodeDeploy\CodeDeployClient;
use Aws\Lambda\LambdaClient;
use Aws\S3\S3Client;

class TestService
{
    /** @var S3Client */
    protected $s3Client;

    /** @var LambdaClient */
    protected $lambdaClient;

    /** @var CodeDeployClient */
    protected $codeDeployClient;

    /**
     * @param S3Client $s3Client
     * @param LambdaClient $lambdaClient
     * @param CodeDeployClient $codeDeployClient
     */
    public function __construct(
        S3Client $s3Client,
        LambdaClient $lambdaClient,
        CodeDeployClient $codeDeployClient
    ) {
        $this->s3Client         = $s3Client;
        $this->lambdaClient     = $lambdaClient;
        $this->codeDeployClient = $codeDeployClient;
    }

    /**
     * @return S3Client
     */
    public function getS3Client()
    {
        return $this->s3Client;
    }

    /**
     * @return LambdaClient
     */
    public function getLambdaClient()
    {
        return $this->lambdaClient;
    }

    /**
     * @return CodeDeployClient
     */
    public function getCodeDeployClient()
    {
        return $this->codeDeployClient;
    }

    /**
     * @return array
     */
    public function getClients()
    {
        return [
            $this->s3Client,
            $this->lambdaClient,
            $this->codeDeployClient
        ];
    }
}
