<?php 
/*
*	@var method
* @var query
*/
if (empty($method)) die(403);

require_once("models/CourseSponsors.php");
require_once("models/Sponsors.php");

use Aws\S3\S3Client;

$credentials = new Aws\Credentials\Credentials(AWS_S3_KEY, AWS_S3_SECRET);
$s3 = new S3Client([
  'version' => 'latest',
  'region'  => 'us-east-2',
  'credentials' => $credentials
]);

$sponsors = New Sponsors;
$course_sponsors = New CourseSponsors;
$helper = New Helper;

$data = json_decode(file_get_contents("php://input"), true);
$query = empty($query) ? 0 : $query;

switch ($method) {

	case 'get-by-course':
		$results = $course_sponsors->get(clean_string($query));
		echo json_encode($results);
		break;

}