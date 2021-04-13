<?php
require 'vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Info
	$bucketName = 'buckettestbp';
	$IAM_KEY = 'AKIARDK6SKHKBGHT';
	$IAM_SECRET = 'RXVWnyNVS4hxHXsNTrErvzoFX9SOUT';
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

	
	$fileURL = 'assets/images/test.jpg'; // Change this

	// For this, I would generate a unqiue random string for the key name. But you can do whatever.
	$keyName = 'assets/images/' . basename($fileURL);
	$pathInS3 = 'https://s3.$S3_REGION.amazonaws.com/' . $bucketName . '/' . $keyName;

	// Add it to S3
	try {
		// You need a local copy of the image to upload.
		// My solution: http://stackoverflow.com/questions/21004691/downloading-a-file-and-saving-it-locally-with-php
		if (!file_exists('/tmp/tmpfile')) {
			mkdir('/tmp/tmpfile');
		}
				
		$tempFilePath = '/tmp/tmpfile/' . basename($fileURL);
		$tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");
		$fileContents = file_get_contents($fileURL);
		$tempFile = file_put_contents($tempFilePath, $fileContents);

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $tempFilePath,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

		// WARNING: You are downloading a file to your local server then uploading
		// it to the S3 Bucket. You should delete it from this server.
		// $tempFilePath - This is the local file path.

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}


	echo 'Done';

	// Now that you have it working, I recommend adding some checks on the files.
	// Example: Max size, allowed file types, etc.
?>
