<?php /** User is requesting a forgot password reset.
 * Verify the user knows something about their account, either the
 * user name or the email address. If successful, this process sends the email to lead them
 * back to resetting the password. This page redirects to /profile/?action=forgotpassword to
 * complete the process if the form is filled out successfully.
 *
 * @todo: DoS attack, can we rate-limit?
 * @todo: counter hacking make sure bot doesn't use this to discover emails/user-names, etc.
 * Don't allow error messages to give too much away in case of hack.
 *
 * @author jf 2016-01-11
 * @param `action` if the action parameter is set it means the user attempted to submit the form.
 * @param `forgot-password-email` Submitted email address to look up.
 * @param `forgot-password-username` Submitted user name to lookup.
 * @param `emailaddress` hacker honeypot.
 * @param `all-clear` hacker honeypot
 */
require_once('../../../services/inxys_common.php');
require_once('../../../services/strings.php');
processSearchRequest();
$debug = (int) getPostOrRequestVar('debug', 0);
$action = strtolower(getPostOrRequestVar('action', '')); // this value tells the page how to function.
$page = 'forgotpass';
$pageTitle = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_TITLE);
$pageDescription = $stringTable->lookup(inxysUIStrings::PROFILE_PAGE_DESCRIPTION);
$hackerVerification = makeInputFormHackerToken();
$inputFocusId = '';
$errorMessage = '';
$errorCode = EnginesisErrors::NO_ERROR;
$showForm = true;
$showErrors = false;

if ($action == 'forgotpassword') {
    // user completed the Forgot Password form, initiate a forgot password flow.
    if (verifyFormHacks(['emailaddress', 'all-clear'])) {
        $userName = getPostVar('forgot-password-username', '');
        $email = getPostVar('forgot-password-email', '');
        if (isValidUserName($userName) || checkEmailAddress($email)) {
            $result = $enginesis->userForgotPassword($userName, $email);
            if ($result != null) {
                if (isset($result->user_id) && $result->user_id > 0) {
                    $errorMessage = '<p class="text-info">' . $stringTable->lookup(EnginesisUIStrings::REG_RESET_PASSWORD, null) . '</p>';
                    $showForm = false;
                } else {
                    $errorMessage = '<p class="text-error">' . $stringTable->lookup(inxysUIStrings::BAD_SERVER_RESPONSE, null) . '</p>';
                    $inputFocusId = 'forgot-password-username';
                    $result = null;
                }
            }
            // The query can return results AND and error if server fails to send email.
            if ($result == null) {
                $error = $enginesis->getLastError();
                $errorCode = $error['message'];
                $info = '';
                if ( ! empty($userName)) {
                    $info = $userName;
                }
                if ( ! empty($email)) {
                    $info = ($info == '' ? '' : ', ') . $email;
                }
                if ($info != '') {
                    $info = '(' . htmlentities($info) . ')';
                }
                debugLog('forgotpassword form submission error '. errorToLocalString($errorCode) . ' ' . $info);
                $errorMessage = '<p class="text-error">' . errorToLocalString($errorCode) . '<br/>' . $stringTable->lookup(inxysUIStrings::CHECK_YOUR_ENTRY, null) . '</p>';
                $inputFocusId = 'forgot-password-username';
            }
        } else {
            // bad parameters
            $errorCode = EnginesisErrors::INVALID_PARAMETER;
            $errorMessage = '<p class="text-error">' . $stringTable->lookup(inxysUIStrings::PASSWORD_RESET_MISSING_ID, null) . '</p>';
        }
    } else {
        debugLog('forgotpassword form submission failed the hacker test.');
        $errorCode = EnginesisErrors::SERVICE_ERROR;
        $errorMessage = '<p class="text-error">' . errorToLocalString($errorCode) . '<br/>' . $stringTable->lookup(inxysUIStrings::CHECK_YOUR_ENTRY, null) . '</p>';
        $inputFocusId = 'forgot-password-username';
    }
    if ( ! $showErrors && $errorCode != EnginesisErrors::INVALID_PARAMETER) {
        // when not showing errors an error is ignored so the user thinks the request succeeded, this is to prevent hackers from mining user accounts.
        $errorMessage = '<p class="text-info">' . $stringTable->lookup(EnginesisUIStrings::REG_RESET_PASSWORD, null) . '</p>';
        $showForm = false;
    }
} else {
    $inputFocusId = 'forgot-password-username';
}
include(VIEWS_ROOT . 'page-header.php');
?>
<div class="container">
    <?php include(VIEWS_ROOT . 'top-nav.php');?>
    <div class="row p-4 justify-content-center">
        <div class="col-md-6 align-self-center">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Forgot Password</h1>
                </div>
                <div class="card-body p-4">
                    <div id="formMessageArea" class="popupMessageArea">
                        <?php echo($errorMessage);?>
                    </div>
                    <?php if ($showForm) { ?>
                    <form id="forgot-password-form" method="POST" action="/procs/forgotpass/">
                        <p>To reset your password, please identify your account with either your user name or your email address. We will send email to the address set on the account to enable you to reset your password.</p>
                        <div class="form-group">
                            <label for="forgot-password-username" class="col-sm-2 col-form-label">User name:</label>
                            <input type="text" id="forgot-password-username" name="forgot-password-username" maxlength="20" class="popup-form-input" placeholder="Your user name" autocorrect="off" autocomplete="username"/>
                        </div>
                        <div class="form-group">
                            <label for="forgot-password-email" class="col-sm-2 col-form-label">Email:</label>
                            <input type="email" id="forgot-password-email" name="forgot-password-email" maxlength="80" class="popup-form-input required email" placeholder="Your email address" autocapitalize="off" autocorrect="off" autocomplete="email"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" id="forgot-password-button" value="Request"/>
                            <input type="hidden" name="action" value="forgotpassword" />
                            <input type="text" name="emailaddress" class="popup-form-address-input" />
                            <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once(VIEWS_ROOT . 'footer.php');
?>
</body>
</html>
