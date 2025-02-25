<?php
/**
 * DO NOT MANUALLY MODIFY THIS FILE
 * THIS FILE EXISTS FOR BACKWARD COMPATIBILITY REASONS ONLY, TRY TO USE ".env"
 *
 * add custom variables to ".env" in project root or create a "vars.php"
 * in this directory if you want to add your own variables
 */
date_default_timezone_set($_ENV['DEFAULT_TIMEZONE']);

// Definitions BEGIN
define('WEB_ROOT', dirname(__DIR__, 2));
define('TRIBE_ROOT', dirname(__DIR__, 1));
define('ABSOLUTE_PATH', dirname(__DIR__, 1));
define('ENV', $_ENV['ENV']);

define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);

define('CONTACT_EMAIL', $_ENV['CONTACT_EMAIL']);
define('WEBSITE_NAME', $_ENV['WEBSITE_NAME']);
define('CONTACT_NAME', $_ENV['CONTACT_NAME']);

define('S3_BKUP_HOST_BASE', ($_ENV['S3_BKUP_HOST_BASE'] ?? ''));
define('S3_BKUP_HOST_BUCKET', ($_ENV['S3_BKUP_HOST_BUCKET'] ?? ''));
define('S3_BKUP_ACCESS_KEY', ($_ENV['S3_BKUP_ACCESS_KEY'] ?? ''));
define('S3_BKUP_SECRET_KEY', ($_ENV['S3_BKUP_SECRET_KEY'] ?? ''));
define('S3_BKUP_FOLDER_NAME', ($_ENV['S3_BKUP_FOLDER_NAME'] ?? ''));

$protocol = "https";
if ($_ENV['SSL'] === 'false') {
    $protocol = "http";
}

// strip protocol from WEB_URL to make it cleaner
$_ENV['WEB_BARE_URL'] = preg_replace('/^https?:\/\//', '', $_ENV['WEB_URL']);

define('BARE_URL', $_ENV['WEB_BARE_URL']);
define('BASE_URL', "{$protocol}://" . BARE_URL);
// Definitions END

// error reporting for dev & prod
switch (ENV) {
    case 'dev':
        error_reporting(E_ALL);
        break;

    case 'prod':
        error_reporting(~E_ALL);
        break;

    default:
        break;
}

// set cors headers in PHP server
if ($_ENV['ALLOW_CROSS_ORIGIN'] === 'true') {
    if (ENV === 'prod') {
        $allowed_origins = [
            $_ENV['WEB_URL'],
            $_ENV['APP_URL'],
            $_ENV['JUNCTION_URL'],
            $_ENV['DOCKER_INTERNAL_TRIBE_URL'],
            $_ENV['DOCKER_INTERNAL_JUNCTION_URL'],
            $_ENV['DOCKER_EXTERNAL_TRIBE_URL'],
            $_ENV['DOCKER_EXTERNAL_JUNCTION_URL'],
        ];

        if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        }

        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
    }
    //in dev environment, allowing cross origin *
    else {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
    }
}
