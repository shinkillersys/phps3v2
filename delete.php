<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = 'buckettestbp';
$keyname = 'assets/images/test.jpg';

// AWS Info
$bucketName = 'buckettestbp';
$IAM_KEY = 'AKIARDK6SKHKBGHTLKNN';
$IAM_SECRET = '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';
$S3_REGION = 'ap-southeast-1';
// Connect to AWS
try {
    // You may need to change the region. It will say in the URL when the bucket is open
    // and on creation. us-east-2 is Ohio, us-east-1 is North Virgina
    $s3 = S3Client::factory(
        array(
            'credentials' => array(
                'key' => $IAM_KEY,
                'secret' => $IAM_SECRET
            ),
            'version' => 'latest',
            'region'  => $S3_REGION
        )
    );
} catch (Exception $e) {
    // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
    // return a json object.
    die("Error: " . $e->getMessage());
}

// 1. Delete the object from the bucket.
try
{
    echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;

    $s3->deleteObject([
        'Bucket' => $bucket,
        'Key'    => $keyname
    ]);
    echo 'done';
}
catch (S3Exception $e) {
    exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
}
?>