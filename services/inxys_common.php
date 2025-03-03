<?php
include_once('common.php');

// Global variables that should be defined on every page
$siteId = 109;
$pageId = '';         // Every page has an id so we can do per-page logic inside common functions
$pageTitle = '';      // Every page has a title, many times this is dynamically generated
$allMenuPages = [
    ['id' => 'home', 'name' => 'Home', 'path' => '/'],
    ['id' => 'conferences', 'name' => 'Conferences', 'path' => '/conf/'],
    ['id' => 'users', 'name' => 'Users', 'path' => '/users/'],
    ['id' => 'profile', 'name' => 'Profile', 'path' => 'profile.php']
];
$isLoggedIn = false;  // true when we have a user logged in
$userId = 0;          // when logged in, this is the id of the logged in user
$serverName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'inxys-l.net');
$serverStage = '';    // One of our server stages: -l, -d, -q, -x. Empty for the production server.

function isActivePage($pageId) {
    global $allMenuPages;
    return in_array($pageId, $allMenuPages) ? 'active' : '';
}

/**
 * Create a URL that a user can link to in order to resend the confirmation email.
 */
function createResendConfirmEmailLink($errorCode, $userId, $userName, $email, $confirmationToken) {
    $regConfirmErrors = [EnginesisErrors::REGISTRATION_NOT_CONFIRMED, EnginesisErrors::INVALID_SECONDARY_PASSWORD, EnginesisErrors::PASSWORD_EXPIRED];
    if (in_array($errorCode, $regConfirmErrors)) {
        $params = '';
        appendParamIfNotEmpty($params, 'u', $userId);
        appendParamIfNotEmpty($params, 'n', $userName);
        appendParamIfNotEmpty($params, 'e', $email);
        appendParamIfNotEmpty($params, 't', $confirmationToken);
        $params .= '&d=' . time();
        return '<a href="/profile/?action=resendconfirm' . $params . '">Resend confirmation</a>';
    } else {
        return '';
    }
}

/**
 * Check if this is a login attempt and if so validate the user.
 * @return Array A key value array with the following:
 * - isLogInAttempt: true if this looks like an attempt to log in.
 * - isLoggedIn: true if the user was successfully logged in.
 * - errorMessage: A non-empty string when a log in error occurred and isLogInAttempt is true and isLoggedIn is false
 * - errorParameter: Which form field was the source the error.
 */
function handleLoginAttempt() {
    global $enginesis;
    global $stringTable;
    $login = getPostVar('loginButton', null);
    $hackerToken = getPostVar('all-clear', '');
    $isLogInAttempt = false;
    $isLoggedIn = false;
    $errorMessage = '';
    $errorParameter = '';

    if ($login != null && validateInputFormHackerToken($hackerToken)) {
        $isLogInAttempt = true;
        // User issued a login request we expect user-name and password
        $userName = getPostVar('login-username');
        $password = getPostVar('login-password');
        $rememberMe = valueToBoolean(getPostVar('rememberme', false));
        $userInfo = $enginesis->userLogin($userName, $password);
        if ($userInfo == null) {
            $error = $enginesis->getLastError();
            if ($error != null) {
                $linkToResendToken = createResendConfirmEmailLink($error['message'], null, $userName, null, null);
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::LOGIN_SYSTEM_FAILURE) . ' ' . errorToLocalString($error['message']) . ' ' . $linkToResendToken;
                $errorParameter = 'login-username';
            } else {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::NAME_PASSWORD_MISMATCH);
                $errorParameter = 'login-username';
            }
        } else {
            $isLoggedIn = true;
            $cr = $userInfo->cr;
            // @todo: Verify hash matches, otherwise we should not trust this info.
            $authToken = $userInfo->authtok;
            $refreshToken = $userInfo->refresh_token;
            $tokenExpires = $userInfo->expires;
            $sessionExpires = $userInfo->session_expires;
            $userId = $userInfo->user_id;
            $errorMessage = "<p class=\"text-error\"> You are logged in as $userId $userInfo->username </p>";
            $errorParameter = 'login-password';
        }
    }
    return [
        'isLogInAttempt' => $isLogInAttempt,
        'isLoggedIn' => $isLoggedIn,
        'errorMessage' => $errorMessage,
        'errorParameter' => $errorParameter
    ];
}

/**
 * Check if a proposed user name is already in use by another account.
 * @param string $userName A proposed user name to check.
 * @return boolean True if user name is not in use by another account, false if the user name is currently assigned to another user.
 */
function checkUserNameUnique($userName) {
    global $enginesis;
    $isUnique = false;
    $enginesisResponse = $enginesis->userGetByName($userName);
    if (empty($enginesisResponse)) {
        $enginesisResult = $enginesis->getLastErrorCode();
        if ($enginesisResult == EnginesisErrors::USER_DOES_NOT_EXIST) {
            $isUnique = true;
        }
    }
    return $isUnique;
}

/**
 * Check if a proposed user email address is already in use by another account.
 * @param string $email A proposed email address to check.
 * @return boolean True if email is not in use by another account, false if the email is currently assigned to another user.
 */
function checkEmailUnique($email) {
    global $enginesis;
    $isUnique = false;
    $enginesisResponse = $enginesis->userGetByEmail($email);
    if (empty($enginesisResponse)) {
        $enginesisResult = $enginesis->getLastErrorCode();
        if ($enginesisResult == EnginesisErrors::USER_DOES_NOT_EXIST) {
            $isUnique = true;
        }
    } elseif (isset($enginesisResponse->user_exists)) {
        $isUnique = $enginesisResponse->user_exists == 0;
    } else {
        // @todo: userGetByEmail can send back a UserGet user object, in that case the user does already exist
        $isUnique = false;
    }
    return $isUnique;
}
