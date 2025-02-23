<?php /** /profile/
* If a user is logged in we show the details about that user
* and the profile functions such as edit, change password, etc. This page can also show the public details about
* another user. Finally, if no user is logged in, this page handles all the prompts and details for login, SSO,
* forgot password.
*
* Valid actions are:
*   login: log in a user with name/password from a login form.
*   logout: log out a user who is currently logged in, clearing all cookies and local data.
*   update: change profile data for the current logged in user.
*   resetpassword: The current logged in user requested a Password Reset, initiate the forgot password flow.
*   resendconfirm: A user needs the registration confirmation form resent (lost it or it expired.)
*   regconfirm: Handle a redirect from regconfirm.php so we can display the error message.
*   view: show the public profile of a specified user.
*/
include_once('../../services/inxys_common.php');
require_once('../../services/strings.php');
$debug = getPostOrRequestVar('debug', 0) == 1;
$pageId = 'profile';
$pageTitle = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_TITLE);
$pageDescription = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_DESCRIPTION);
processTrackBack();
$action = strtolower(getPostOrRequestVar('action', '')); // this value tells the page how to function.
$userName = '';
$redirectedStatusMessage = '';

if ($action == 'regconfirm') {
    // A redirect from regconfirm.php so we can complete registration and display any error message
    $code = getPostOrRequestVar('code', '');
    if ($code == 'NO_ERROR' || $code == 'SUCCESS' || $code == '') {
        $redirectedStatusMessage = $stringTable->lookup(EnginesisUIStrings::WELCOME_MESSAGE, null);
        // @todo: Verify the cookie/token matches this user
        // @todo: There should be a safeguard if a hacker comes with action+code but is really not the user we think he is spoofing
        $userInfo = $enginesis->getLoggedInUserInfo();
        $isValidSession = verifySessionIsValid($userId, $authToken);
        $isLoggedIn = true;
        $authToken = $userInfo->authtok;
        $refreshToken = $userInfo->refreshToken;
        $userId = $userInfo->user_id;
        $enginesis->userLoginRefresh();
    } else {
        $user_user_id = getPostOrRequestVar('u', '');
        $confirmation_token = getPostOrRequestVar('t', '');
        $linkToResendToken = createResendConfirmEmailLink($code, $user_user_id, $userName, '', $confirmation_token);
        $redirectedStatusMessage = errorToLocalString($code);
    }
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
<div id="user-profile" class="card m-2 p-4">
    <?php
    if ($redirectedStatusMessage != '') {
        echo ('<div class="card text-bg-danger"><div class="card-body"><p class="card-text">' . $redirectedStatusMessage . '</p></div></div>');
    }
    if ($debug) {
        echo ("<h3>Debug info:</h3>");
    }
    ?>
    <h1>User profile</h1>
    <p>Create an account for free. You get one public conference with your free account.</p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>