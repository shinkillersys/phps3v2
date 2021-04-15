//Dùng vòng for để upload folder.
<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


// AWS Info
$bucketName = 'buckettestbp';
$IAM_KEY = 'XXX';
$IAM_SECRET = 'XXX';
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
$dir = "/home/thinh/Desktop/phps3v2/assets/images/*";

//For each file in your directory run the putObject S3 Api function
foreach (glob($dir) as $file) {
    $file_name = str_replace('/home/thinh/Desktop/phps3v2/assets/images', '', $file);
    echo "Upload File Key : ".$file_name . "\n";
    echo "Upload File Path : ".$file. "\n \n";
    $result = $s3->putObject([
        'Bucket' => $bucketName,
        'Key'    => 'assets/images'.$file_name,
        'Body' => fopen($file, 'r+')
    ]);

    // Wait for the file to be uploaded and accessible :
    $s3->waitUntil('ObjectExists', array(
      'Bucket' => $bucketName,
      'Key'    => 'assets/images'.$file_name
  ));
}
?>
