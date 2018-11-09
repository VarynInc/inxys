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
define('SERVICE_ROOT', $serverRootPath . '..' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR);
define('VIEWS_ROOT', $serverRootPath . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

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

/**
 * Verify the sever stage we are running on is sufficient to run Enginesis. There are a set of required
 * modules we need in order for the platform to operate. This function returns an array of either only
 * the failed tests, or the status of all tests.
 * @param $includePassedTests boolean set to false to return only failed tests, set to true to return
 *        both failed tests and passed tests. default is false.
 * @return array a key value array where the key is the test performed and the value is a boolean
 *        indicating the test passed (true) or the test failed (false).
 */
function verifyStage($includePassedTests = false) {
    $testStatus = [];

    // Test for required PHP version
    $test = 'php-version';
    $isValid = version_compare(phpversion(), '7.2.0', '>=');
    if ( ! $isValid || ($isValid && $includePassedTests)) {
        $testStatus[$test] = $isValid;
    }

    // Test for required modules/extensions
    $requiredExtensions = ['openssl', 'curl', 'json', 'gd', 'PDO', 'pdo_mysql'];
    $extensions = get_loaded_extensions();
    foreach($requiredExtensions as $i => $test) {
        $isValid = in_array($test, $extensions);
        if ( ! $isValid || ($isValid && $includePassedTests)) {
            $testStatus[$test] = $isValid;
        }
    }

    // Test for required gd support
    $test = 'gd';
    $isValid = function_exists('gd_info');
    if ($isValid) {
        $gdInfo = gd_info();
        $test = 'gd-jpg';
        $isValid = $gdInfo['JPEG Support'];
        if ( ! $isValid || ($isValid && $includePassedTests)) {
            $testStatus[$test] = $isValid;
        }
        $test = 'gd-png';
        $isValid = $gdInfo['PNG Support'];
        if ( ! $isValid || ($isValid && $includePassedTests)) {
            $testStatus[$test] = $isValid;
        }
    } else {
        $testStatus[$test] = $isValid;
    }

    // test for required openssl support
    $test = 'openssl';
    $isValid = function_exists('openssl_encrypt') && function_exists('openssl_get_cipher_methods');
    if ( ! $isValid || ($isValid && $includePassedTests)) {
        $testStatus[$test] = $isValid;
    }

    // Verify we have the right version of openssl
    $test = 'openssl-version';
    $openSSLMinVersion = 9470367;
    $isValid = OPENSSL_VERSION_NUMBER >= $openSSLMinVersion;
    if ( ! $isValid || ($isValid && $includePassedTests)) {
        $testStatus[$test] = $isValid;
    }
    return $testStatus;
}

require_once('version.php');
require_once('status.php');
require_once('config.php');
