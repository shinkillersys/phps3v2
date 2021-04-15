//Dùng Thư viện tranfer của aws để up load folder.

<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\S3\Transfer;

// AWS Info
$IAM_KEY = 'XXX';
$IAM_SECRET = 'XXX';
$S3_REGION = 'ap-southeast-1';

// Create an S3 client
$client = new \Aws\S3\S3Client([
    'credentials' => array(
        'key' => $IAM_KEY,
        'secret' => $IAM_SECRET
    ),
    'version' => 'latest',
    'region'  => $S3_REGION
]);

// Where the files will be source from
$source = '/home/thinh/Desktop/phps3v2/assets/images';

// Where the files will be transferred to
$dest = 's3://buckettestbp';

// Create a transfer object.
$manager = new \Aws\S3\Transfer($client, $source, $dest);

// Perform the transfer synchronously.
$manager->transfer();