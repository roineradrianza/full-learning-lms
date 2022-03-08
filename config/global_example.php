<?php 
//Database IP server
define("DB_HOST","localhost");

//Database name
define("DB_NAME", "database");

//Database user
define("DB_USERNAME", "root");

//Database user's password
define("DB_PASSWORD", "");

//Character encoding
define("DB_ENCODE", "utf8");

//Project Name
define("PROJECT_NAME", "Full Learning");

/*PayPal Credentials*/
define('PAYPAL_CLIENT_ID', '');

/*Email SMTP data*/
define("EMAIL_ACCOUNT", "user@test.com");

define("EMAIL_HOST", "smtp.gmail.com");

define("EMAIL_PASSWORD", "");

define("GOOGLE_CLIENT_ID", "");

define('AWS_S3_KEY', '');
define('AWS_S3_SECRET', '');
define('AWS_S3_REGION', 'us-east-2');
define('AWS_S3_BUCKET', '');

define('AWS_CFI_FOLDER', 'featured-images/');
define('AWS_CCBI_FOLDER', 'certified-by-images/');
define('AWS_CC_FOLDER', 'certifieds/');
define('AWS_MEDIA_FOLDER', 'media/');
define('AWS_A_FOLDER', 'avatars/');

//IS DEVELOPMENT ENVIROMENT

define('DEV_ENV', true);

//Encryption key
define("ENCRYPT_KEY", '');

define("DIRECTORY", $_SERVER['DOCUMENT_ROOT']);
//Check if current server has server ssl activated
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}
$protocol = $isSecure ? 'https://' : 'http://';
define('IS_SECURE', $isSecure);
define('REQUEST_PROTOCOL', $protocol);
define('SITE_URL', REQUEST_PROTOCOL . $_SERVER['HTTP_HOST']);
?>