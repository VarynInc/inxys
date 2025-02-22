<?php /* Sign up to register a new inXys account */
include_once('../../services/inxys_common.php');
include_once('../../services/strings.php');
$pageId = 'signup';
$pageTitle = 'Create your inXys account';
$signupErrorMessage = '';
$signupSuccessful = false;

/**
 * Perform account sign up validation to determine if we have enough information
 * to create the new account. THis function does the validation and returns the following:
 * @return array The following properties are returned:
 *   - `isSignUpAttempt`: true is this looks like an attempt to sign up.
 *   - `isLoggedIn`: true if the user is registered and we logged them is.
 *   - `errorMessage`: If a sign up attempt failed this is the reason.
 *   - `errorParameter`: If the sign up attempt failed this is the input field we didn't like.
 *   - `rememberUser`: true if the user checked the Remember Me checkbox.
 */
function handleSignUpAttempt() {
    global $enginesis;
    global $stringTable;

    $signUp = getPostVar('signupButton', '');
    $action = getPostVar('action', '');
    $hackerToken = getPostVar('all-clear', '');
    $login = getPostVar('loginButton', null);
    $hackerToken = getPostVar('all-clear', '');
    $isSignUpAttempt = false;
    $isLoggedIn = false;
    $errorMessage = '';
    $errorParameter = '';
    $rememberMe = false;
    $userInfo = [];

    if ($signUp != null && $action == 'signup' && validateInputFormHackerToken($hackerToken)) {
        $isSignUpAttempt = true;
        if ($errorMessage == '') {
            // user name must be valid and unique
            $formField = 'signup-username';
            $userName = cleanString(strip_tags(getPostVar($formField, '')));
            if ( ! isValidUserName($userName)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_INVALID);
                $errorParameter = $formField;
            } elseif ( ! checkUserNameUnique($userName)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_NAME_IN_USE);
                $errorParameter = $formField;
            } else {
                $userInfo['user_name'] = $userName;
            }
        }
        if ($errorMessage == '') {
            // email must valid and not assign to another account
            $formField = 'signup-email';
            $email = strip_tags(getPostVar($formField, ''));
            if ( ! checkEmailAddress($email)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::INVALID_EMAIL);
                $errorParameter = $formField;
            } elseif ( ! checkEmailUnique($email)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_EMAIL_IN_USE);
                $errorParameter = $formField;
            } else {
                $userInfo['email_address'] = $email;
            }
        }
        if ($errorMessage == '') {
            // password strength
            $formField = 'signup-password';
            $password = strip_tags(getPostVar($formField, ''));
            if ( ! isValidPassword($password)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_INVALID_PASSWORD);
                $errorParameter = $formField;
            } else {
                $userInfo['password'] = $password;
            }
        }
        if ($errorMessage == '') {
            // agree to terms
            $formField = 'agree-terms';
            $agreeToTerms = getPostVar('agree-terms', '');
            if ($agreeToTerms != 'on') {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_TOS);
                $errorParameter = $formField;
            } else {
                $userInfo['agreement'] = 1;
            }
        }
        $rememberMe = getPostVar('rememberme', '') == 'on';
        if ($errorMessage == '') {
            $userInfo['dob'] = '2010-01-01';
            $userInfo['gender'] = 'U';
            $userInfo['real_name'] = $userName;
            $userInfo['security_question_id'] = 1;
            $userInfo['security_answer'] = 'yes';
            $userInfo['city'] = '';
            $userInfo['state'] = '';
            $userInfo['zipcode'] = '';
            $userInfo['country_code'] = '';
            $userInfo['tagline'] = '';
            $userInfo['mobile_number'] = '';
            $userInfo['im_id'] = '';
            $userInfo['img_url'] = '';
            $userInfo['about_me'] = '';
            $userInfo['additional_info'] = '';
            $userInfo['captcha_id'] = '99999';
            $userInfo['captcha_response'] = 'DEADMAN';
            $userInfo['site_user_id'] = '';
            $userInfo['network_id'] = 1;
            $userInfo['source_site_id'] = 109;
            $enginesisResponse = $enginesis->userRegistration($userInfo);
            if (isset($enginesisResponse->results)) {
                $results = $enginesisResponse->results;
                if (isset($results->status)) {
                    $success = $results->status->success;
                    if ($success == 0) {
                        // registration failed
                        $errorParameter = 'signup-username';
                        $errorMessage = $results->status->message . ' ' . $results->status->extended_info;
                    } else {
                        // Successful registration. Email is sent to user with user_id & secondary_Password to confirm registration.
                    }
                }
            } else {
                $errorDetails = $enginesis->getLastError();
                if ($errorDetails['success'] == 0) {
                    // registration failed probably due to a system bug
                    if ($enginesis->getServerStage() == '') {
                        $errorInfo = 'exception in registration service';
                    } else {
                        $errorInfo = ['error' => $errorDetails['message'] . ' ' . $errorDetails['extended_info']];
                    }
                    $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_ERROR, $errorInfo);
                    $errorParameter = 'signup-username';
                } else {
                    // Successful registration. Email is sent to user with user_id & secondary_Password to confirm registration.
                }
            }
        }
    } else {
        $errorMessage = $stringTable->lookup(EnginesisUIStrings::REG_INFO_INCOMPLETE);
        $errorParameter = 'signup-username';
    }
    return [
        'isSignUpAttempt' => $isSignUpAttempt,
        'isLoggedIn' => $isLoggedIn,
        'errorMessage' => $errorMessage,
        'errorParameter' => $errorParameter,
        'rememberUser' => $rememberMe
    ];
}
$signUpResult = handleSignUpAttempt();
$isSignUpAttempt = $signUpResult['isSignUpAttempt'];
if ($isSignUpAttempt) {
    if ( ! empty($signUpResult['errorMessage'])) {
        $signupErrorMessage = $signUpResult['errorMessage'];
    } else {
        $signupSuccessful = true;
    }
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Sign up</h1>
    <?php if ($signupSuccessful) { ?>
    <div class="row justify-content-md-center">
        <div class="col col-md-4"></div>
        <div class="col col-md-4 align-self-center login-form p-3">
            <p>Welcome to the Information Exchange! Your registration was successful. In order to complete your registration,
            you will receive an email asking you to confirm your account. Your account is not active until you complete the email confirmation.</p>
            <p>Please check your email and use the link provided to complete your registration.</p>
        </div>
        <div class="col col-md-4"></div>
    </div>
    <?php } else { ?>
    <div class="row justify-content-md-center">
        <div class="col col-md-4"></div>
        <div class="col col-md-4 align-self-center">
            <?php if ($signupErrorMessage != '') {
                echo('<div class="modalMessageArea"><p class="text-error">' . $signupErrorMessage . '</p></div>');
            }
            include(VIEWS_ROOT . 'signup.php');?>
        </div>
        <div class="col col-md-4"></div>
    </div>
    <p>
        Create an account for free. You get one public conference with your free account.
    </p>
    <p>
        Already a member? <a class="btn btn-primary" href="/" role="button">Log in &raquo;</a>
    </p>
    <p>
        By registering you agree to the <a href="/terms/">Terms of Service</a>. We require a valid email address. Once you register
        you will receive an email asking you to confirm your email address. Your account is not active until you complete
        the email confirmation.
    </p>
    <?php } ?>
</div>
<?php
include(VIEWS_ROOT . 'footer.php');
if ($isSignUpAttempt) {
    $errorParameter = $signUpResult['errorParameter'];
    if ( ! empty($errorParameter)) {
?>
<script>
    const formElement = document.getElementById("<?php echo($errorParameter);?>");
    if (formElement) {
        formElement.focus();
        formElement.classList.add("login-form-input-error");
    }
</script>
<?php
    }
}
?>
<script src="/js/signup.js" type="module"></script>
</body>
</html>
