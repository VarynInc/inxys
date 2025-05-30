<?php /** /profile/ is the user's profile page.
* If a user is logged in we show the details about that user and the profile functions
* such as edit, change password, etc. This page can also show the public details about
* another user. Finally, if no user is logged in, this page handles all the prompts
* and details for login, SSO, forgot password.
*
* Valid actions are:
*   login: log in a user with name/password from a login form.
*   signout: log out a user who is currently logged in, clearing all cookies and local data.
*   resetpass: The current logged in user requested a Password Reset, initiate the forgot password flow.
*   resendconfirm: A user needs the registration confirmation form resent (lost it or it expired.)
*   regconfirm: Handle a redirect from regconfirm.php so we can display the error message or complete the log in.
*   view: show the public profile of a specified user.
*/
include_once('../../services/inxys_common.php');
require_once('../../services/strings.php');
require_once('../../services/profile.php');
$debug = getPostOrRequestVar('debug', 0) == 1;
$pageId = 'profile';
$pageTitle = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_TITLE);
$pageDescription = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_DESCRIPTION);
processTrackBack();
$action = strtolower(getPostOrRequestVar('action', '')); // this value tells the page how to function.
$userName = '';
$redirectedStatusMessage = '';
$registrationErrorCode = '';

if ($action == 'regconfirm') {
    // A redirect from regconfirm.php so we can complete registration and display any error message.
    completeUserRegistration($registrationErrorCode, $redirectedStatusMessage);
} elseif ($action == 'resendconfirm') {
    // called from login when the user has not confirmed their email with https://inxys-l.net/profile/?action=resendconfirm&n=jim&d=1745976307
    resendConfirmationNotification($registrationErrorCode, $redirectedStatusMessage);
} elseif ($action == 'resetpass') {
    resetPassword($registrationErrorCode, $redirectedStatusMessage);
} elseif ($action == 'view') {
    viewUserProfile($registrationErrorCode, $redirectedStatusMessage);
} elseif ($action == 'signout') {
    $enginesis->userLogout();
    header("location: /");
    exit();
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
<div id="user-profile" class="card m-2 p-4">
    <?php
    if ($redirectedStatusMessage != '') {
        $panelClass = $registrationErrorCode == 'SUCCESS' ? 'text-bg-success' : 'text-bg-danger';
        echo('<div class="card ' . $panelClass . '"><div class="card-body"><p class="card-text">' . $redirectedStatusMessage . '</p></div></div>');
        if ($action == 'regconfirm' && $registrationErrorCode != 'SUCCESS') {
            echo('<div class="col-10 col-md-8 col-lg-6 align-self-center login-form p-3"><p>Your account is not active until you complete the email confirmation.</p><p>Please check your email and use the link provided to complete your registration, or ' . $linkToResendToken . '.</p></div>');
        }
    }
    if ($debug) {
        echo ("<h3>Debug info:</h3>");
    }
    if ($isLoggedIn) {
    ?>
    <h1><?php echo(formattedUserName($userInfo));?></h1>
    <div class="btn-group" role="group" aria-label="Profile options">
        <a class="btn btn-sm btn-outline-primary" href="/profile/edit/" role="button">Edit profile &raquo;</a>
        <a class="btn btn-sm btn-outline-primary" href="/profile/scratchpad/" role="button">Enter scratchpad</a>
        <a class="btn btn-sm btn-outline-primary" href="/profile/?action=signout" role="button">Log out</a>
    </div>
    <?php
    } elseif ($action == 'resendconfirm' && $redirectedStatusMessage == '') {
    ?>
    <div class="col-10 col-md-8 col-lg-6 align-self-center login-form p-3">
        <p>Confirmation email has been resent to the email address on file for your account.
        Your account is not active until you complete the email confirmation.</p>
        <p>Please check your email and use the link provided to complete your registration.</p>
        <p class="text-center"><a class="btn btn-primary" href="/" role="button">Log in &raquo;</a></p>
    </div>
    <?php
    } elseif ($registrationErrorCode == '') {
    ?>
    <h1>User profile</h1>
    <p>Create an account for free. You get one public conference with your free account.</p>
    <p>Have an account? <a class="btn btn-lg btn-success" href="/" role="button">Log in &raquo;</a></p>
    <p>Not a member? <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a></p>
    <?php
    }
    ?>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
