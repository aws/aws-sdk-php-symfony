<?php

namespace Aws\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AwsBundle extends Bundle
{
    const VERSION = '2.0.0';
    
    /**
     * @inheritDoc
     */
    public function boot()
    {
        parent::boot();

        // Register S3 StreamWrapper
        if ($this->container->has('aws.s3')) {
            /** @var S3Client $s3 */
            $s3 = $this->container->get('aws.s3');
            $s3->registerStreamWrapper();
        }
    }
}
