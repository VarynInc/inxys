<?php
include_once('../../services/inxys_common.php');
$pageId = 'forgotpassword';
$pageTitle = 'Forgot password | inXys';
$pageDescription = 'Use this form to reset your password.';
$loggedIn = false;

$userName = getPostOrRequestVar('userName', '');
$email = getPostOrRequestVar('email', '');
$errorMessage = '';
$reset = false;
$hackerVerification = '';

if ($userName != '' || $email != '') {
    $errorMessage = resetUserPassword($userName, $email);
    if ($errorMessage == '') {
        $reset = true;
    } else {
        if ($errorMessage == 'INVALID_USER_ID') {
            $errorMessage = '<p class="errormsg">There is no account with the information you supplied.</p>';
        }
    }
}

if ( ! $loggedIn) {
    $allToActionButton = ' <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a>';
} else {
    $allToActionButton = '';
}

/**
 * Start the process to reset a users password. We require one of the user_id, user_name, or email_address
 * of the user to reset. Once valid, the account is marked with a temporary password. Then an email is
 * sent to the email_address that belongs to the account. Responding to that email brings the user back
 * with a token to match the account record and the password can be changed.
 *
 * @param $userName
 * @param $emailAddress
 * @return null|string
 */
function resetUserPassword ($userName, $emailAddress) {
    global $serverName;
    global $emailNotificationTypeIds;

    $site_id = 109;
    $language_code = 'en';
    $dbOpenedHere = false;
    if ( ! dbIsActiveConnection()) {
        dbConnect();
        $dbOpenedHere = true;
    }
    $success = 0;
    $status_msg = 'ERROR';
    $sql ='call RegisteredUserForgotPassword(?, null, ?, ?, ?, @success, @status_msg); select @success, @status_msg;';
    $params = array($site_id, $userName, $emailAddress, $language_code);
    $queryResults = dbQuery($sql, $params);
    if (dbError($queryResults)) {
        $errorMessage = dbError($queryResults);
    } else {
        do {
            $rowSet = dbFetchAll($queryResults); // should be temp password and email address.
            if (isset($rowSet[0])) {
                if (isset($rowSet[0]['@success'])) {
                    $success = $rowSet[0]['@success'] == 1;
                    $status_msg = $rowSet[0]['@status_msg'];
                } elseif (isset($rowSet[0]['email_address'])) {
                    $emailAddress = $rowSet[0]['email_address'];
                    $user_id = $rowSet[0]['user_id'];
                    $user_name = $rowSet[0]['user_name'];
                    $token = $rowSet[0]['secondary_password'];
                }
            }
        } while (dbNextResult($queryResults));
        dbClearResults($queryResults);
        if ($success) {
            $errorMessage = '';
            // Reset succeeded, now send the email prompting the user to reset their password.
            $parameters = array(
                'site_id' => $site_id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'token' => $token,
                'date' => date('F j, Y'),
                'domain' => $serverName
            );
            $game_id = 0;
            SendUserEmailNotification($emailAddress, $site_id, $user_id, $game_id, $emailNotificationTypeIds['ForgotPassword'], $language_code, $parameters);
        } else {
            $errorMessage = $status_msg;
        }
    }
    if ($dbOpenedHere) {
        dbClose();
    }
    return $errorMessage;
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="row leader-3">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="panel-title">Forgot Password</h1>
                </div>
                <div class="panel-body">
                    <?php
                    if ($reset) {
                        ?>
                        <p>Email has been sent to the owner of this account. Please follow the instructions in that message to reset the account password.</p>
                        <p><a href="login.php">Login</a></p>
                        <p><a href="mailto:support@enginesis.com">Contact Support</a></p>
                        <?php
                    } else {
                        ?>
                        <form id="forgot-password-form" method="POST" action="../profile.php" onsubmit="return varynApp.formForgotPasswordClicked();">
                            <div class="popupMessageArea">
                            </div>
                            <p>Please identify your account. We will send email to the address set on the account to allow you to reset your password.</p>
                            <div class="form-group">
                                <label for="forgotpassword_username_form">User name:</label>
                                <input type="text" id="forgotpassword_username_form" name="forgotpassword_username_form" tabindex="23" maxlength="20" class="popup-form-input"  placeholder="Your user name" autocorrect="off" autocomplete="name"/>
                            </div>
                            <div class="form-group">
                                <label for="forgotpassword_email_form">Email:</label>
                                <input type="email" id="forgotpassword_email_form" name="forgotpassword_email_form" tabindex="24" maxlength="80" class="popup-form-input required email" placeholder="Your email address" autocapitalize="off" autocorrect="off" autocomplete="email"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" id="forgot-password-button" value="Reset" tabindex="25"/>
                                <input type="hidden" name="action" value="forgotpassword" />
                                <input type="text" name="emailaddress" class="popup-form-address-input" />
                                <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
