<?php
date_default_timezone_set('America/New_York');
define('LOGFILE_PREFIX', 'inxys_php_');
define('SERVICES_REPLY_ENCRYPTED', false);
define('COREG_TOKEN_KEY', '9A3462AE95CA72BA');

// determines where there is a secured writable area we can manipulate file storage
if (isset($_SERVER['DOCUMENT_ROOT']) && strlen($_SERVER['DOCUMENT_ROOT']) > 0) {
    $serverRootPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
} else {
    $serverRootPath = '';
}
define('SERVER_ROOT', $serverRootPath);
define('SERVER_DATA_PATH', $serverRootPath . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
define('SERVICE_ROOT', $serverRootPath . '..' . DIRECTORY_SEPARATOR . 'sitedev' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR);
define('VIEWS_ROOT', $serverRootPath . '..' . DIRECTORY_SEPARATOR . 'sitedev' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// determines where the root of the avatar data is held, must be in a public folder
define('SITE_AVATAR_PATH', DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR);

// access to our session data
define('SESSION_DAYSTAMP_HOURS', 48);
define('SESSION_COOKIE', 'inxys-session');
define('SESSION_HASH', 'cr');
define('SESSION_AUTHTOKEN', 'authtok');
define('SESSION_ADMIN_COOKIE', 'inxys_admin');
define('SESSION_USERID_CACHE', 'inxys_userid');
define('SESSION_USERNAME_CACHE', 'inxys_username');
define('SESSION_PARAM_CACHE', 'inxys_params');
define('SESSION_USERINFO', 'inxys_user');

$serverName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'inxys-l.com';
$serverStage = '';
preg_match('/-[d|l|q|x]./i', $serverName, $matched);
if (count($matched) > 0) {
    $serverStage = str_replace('.', '', $matched[0]);
}
$serverStage = strtolower($serverStage);

function currentPageName() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

require_once('version.php');
require_once('status.php');
require_once('config.php');
