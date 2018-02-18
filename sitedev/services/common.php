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

// Global variables that should be defined on every page
$pageId = '';         // Every page has an id so we can do per-page logic inside common functions
$pageTitle = '';      // Every page has a title, many times this is dynamically generated
$allMenuPages = array(array('id' => 'home', 'name' => 'Home', 'path' => '/'),
                      array('id' => 'conferences', 'name' => 'Conferences', 'path' => '/conf/'),
                      array('id' => 'users', 'name' => 'Users', 'path' => '/users/'),
                      array('id' => 'groups', 'name' => 'Groups', 'path' => '/groups/'),
                      array('id' => 'profile', 'name' => 'Profile', 'path' => 'profile.php'));
$isLoggedIn = false;  // true when we have a user logged in
$userId = 0;          // when logged in, this is the id of the logged in user
$serverName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'inxys-l.com';
$serverStage = '';    // One of our server stages: -l, -d, -q, -x. Empty for the production server.

preg_match('/-[d|l|q|x]./i', $serverName, $matched);
if (count($matched) > 0) {
    $serverStage = str_replace('.', '', $matched[0]);
}
$serverStage = strtolower($serverStage);

function currentPageName() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

function isActivePage($pageId) {
    global $allMenuPages;
    return in_array($pageId, $allMenuPages) ? 'active' : '';
}

/**
 * Return a variable that was posted from a form, or in the REQUEST object (GET or COOKIES), or a default if not found.
 * This way POST is the primary concern but if not found will fallback to the other methods.
 * @param $varName {string|Array} variable to read from request. If array, iterates array of strings until the first entry returns a result.
 * @param null $defaultValue
 * @return null
 */
function getPostOrRequestVar ($varName, $defaultValue = NULL) {
    $value = null;
    if (is_array($varName)) {
        for ($i = 0; $i < count($varName); $i ++) {
            $value = getPostOrRequestVar($varName[$i], null);
            if ($value != null) {
                break;
            }
        }
        if ($value == null) {
            $value = $defaultValue;
        }
    } else {
        if (isset($_POST[$varName])) {
            $value = $_POST[$varName];
        } elseif (isset($_GET[$varName])) {
            $value = $_GET[$varName];
        } elseif (isset($_REQUEST[$varName])) {
            $value = $_REQUEST[$varName];
        } else {
            $value = $defaultValue;
        }
    }
    return $value;
}

require_once('version.php');
require_once('status.php');
require_once('config.php');
