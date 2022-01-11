<?php

declare(strict_types=1);

require_once('Assert.php');

use Aws\S3\S3Client;

/**
 * @param array $event
 * @return void
 */
function index(array $event): void
{
    Assert::notEmpty($_ENV['DESTINATION_S3_BUCKET_NAME'],  '$_ENV["DESTINATION_S3_BUCKET_NAME"] must be provided.');

    /** @var array $records */
    $records = $event['Records'];

    foreach ($records as $record) {
        $message = json_decode($record['Sns']['Message'], true);

        /** @var string */
        $sourceBucketName = $message['Records'][0]['s3']['bucket']['name'];

        /** @var string */
        $sourceObjectKey = $message['Records'][0]['s3']['object']['key'];

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-northeast-1'
        ]);

        $destinationBucketName = $_ENV['DESTINATION_S3_BUCKET_NAME'];

        $destinationObjectKey = $sourceObjectKey;

        Assert::isTrue($sourceBucketName !== $destinationBucketName, '$sourceBucketName and $destinationBucketName must be different');

        $s3Client->copyObject([
            'Bucket'     => $destinationBucketName,
            'Key'        => "{$destinationObjectKey}",
            'CopySource' => "{$sourceBucketName}/{$sourceObjectKey}",
        ]);

        print(<<< EOT
        Successfully copied s3 object.
        Source:
            Bucket Name: $sourceBucketName
            Object Key: $sourceObjectKey
        Destination:
            Bucket Name: $destinationBucketName
            Object Key: $destinationObjectKey\n
        EOT);
    }
}
