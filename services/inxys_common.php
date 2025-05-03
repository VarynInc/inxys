<?php
include_once('common.php');

// Global variables that should be defined on every page
$pageId = '';         // Every page has an id so we can do per-page logic inside common functions
$pageTitle = '';      // Every page has a title, many times this is dynamically generated
$allMenuPages = [
    ['id' => 'home', 'name' => 'Home', 'path' => '/'],
    ['id' => 'conferences', 'name' => 'Conferences', 'path' => '/conf/'],
    ['id' => 'users', 'name' => 'Users', 'path' => '/users/'],
    ['id' => 'profile', 'name' => 'Profile', 'path' => '/profile/']
];
$userInfo = restoreLoggedInUser();
$isLoggedIn = $userInfo != null;
$userId = $isLoggedIn ? $userInfo->user_id : 0;
$serverName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'inxys-l.net');
$serverStage = '';    // One of our server stages: -l, -d, -q, -x. Empty for the production server.

/**
 * Determine if the requested page is the current active page.
 * @param String A page id to check (see global $allMenuPages array)
 * @return Boolean True if the requested page is considered active.
 */
function isActivePage($pageId) {
    global $allMenuPages;
    return in_array($pageId, $allMenuPages) ? 'active' : '';
}

/**
 * If no user is logged in then redirect to the indicated page.
 * @param String A page to redirect to. If not provided then redirect to the home page.
 */
function redirectIfNotLoggedIn($page) {
    global $isLoggedIn;
    if ( ! $isLoggedIn) {
        if (empty($page)) {
            $page = '/';
        }
        header('location: ' . $page);
        exit(9);
    }
}

/**
 * Create a URL that a user can link to in order to resend the confirmation email.
 */
function createResendConfirmEmailLink($userId, $userName, $email, $confirmationToken) {
    global $stringTable;
    $params = '';
    appendParamIfNotEmpty($params, 'u', $userId);
    appendParamIfNotEmpty($params, 'n', $userName);
    appendParamIfNotEmpty($params, 'e', $email);
    appendParamIfNotEmpty($params, 't', $confirmationToken);
    $params .= '&d=' . time();
    $prompt = $stringTable->lookup(inxysUIStrings::RESEND_CONFIRMATION_EMAIL);
    return '<a href="/profile/?action=resendconfirm' . $params . '">' . $prompt . '</a>';
}

function restoreLoggedInUser() {
    global $enginesis;
    return $enginesis->getLoggedInUserInfo();
}

/**
 * Check if this is a login attempt and if so validate the user.
 * @param String User name to log in.
 * @param String User's password.
 * @param Boolean True to remember the user login session on this device.
 * @return Array A key value array with the following:
 * - isLogInAttempt: true if this looks like an attempt to log in.
 * - isLoggedIn: true if the user was successfully logged in.
 * - errorMessage: A non-empty string when a log in error occurred and isLogInAttempt is true and isLoggedIn is false
 * - errorParameter: Which form field was the source the error.
 */
function handleLoginAttempt($userName, $password, $rememberMe) {
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
        $userInfo = $enginesis->userLogin($userName, $password);
        if ($userInfo == null) {
            $error = $enginesis->getLastError();
            if ($error != null) {
                // log in failed but there are several reasons
                $errorCode = $error['message'];
                $linkToResendToken = createResendConfirmEmailLink($errorCode, null, $userName, null, null);
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::LOGIN_SYSTEM_FAILURE) . ' ' . errorToLocalString($errorCode);
                if ($errorCode == EnginesisErrors::REGISTRATION_NOT_CONFIRMED) {
                    $errorMessage .= ' ' . $linkToResendToken;
                }
                $errorParameter = 'login-username';
            } else {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::NAME_PASSWORD_MISMATCH);
                $errorParameter = 'login-username';
            }
        } else {
            $isLoggedIn = true;
            $errorMessage = "<p class=\"text-success\"> You are logged in as " . formattedUserName($userInfo) . ".</p>";
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

function formattedUserName($userInfo) {
    if ($userInfo) {
        return $userInfo->real_name . ' (' . $userInfo->user_name . ', ' . $userInfo->user_id . ')';
    } else {
        return 'Anonymous (anon, 0)';
    }
}
