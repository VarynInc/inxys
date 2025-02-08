<?php
include_once('../../services/inxys_common.php');
include_once('../../services/strings.php');
$pageId = 'signup';
$pageTitle = '';
$signupErrorMessage = '';

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
            }
        }
        if ($errorMessage == '') {
            // email must valid and not be assign to another account
            $formField = 'signup-email';
            $email = strip_tags(getPostVar($formField, ''));
            if ( ! checkEmailAddress($email)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::INVALID_EMAIL);
                $errorParameter = $formField;
            } elseif ( ! checkEmailUnique($email)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_EMAIL_IN_USE);
                $errorParameter = $formField;
            }
        }
        if ($errorMessage == '') {
            // password strength
            $formField = 'signup-password';
            $password = strip_tags(getPostVar($formField, ''));
            if ( ! isValidPassword($password)) {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_INVALID_PASSWORD);
                $errorParameter = $formField;
            }
        }
        if ($errorMessage == '') {
            // agree to terms
            $formField = 'agree-terms';
            $agreeToTerms = getPostVar('agree-terms', '');
            if ($agreeToTerms != 'on') {
                $errorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_TOS);
                $errorParameter = $formField;
            }
        }
        $rememberMe = getPostVar('rememberme', '');
    } else {
        $errorMessage = $stringTable->lookup(EnginesisUIStrings::REG_INFO_INCOMPLETE);
        $errorParameter = 'signup-username';
    }
    return [
        'isSignUpAttempt' => $isSignUpAttempt,
        'isLoggedIn' => $isLoggedIn,
        'errorMessage' => $errorMessage,
        'errorParameter' => $errorParameter
    ];
}
$signUpResult = handleSignUpAttempt();
$isSignUpAttempt = $signUpResult['isSignUpAttempt'];
if ($isSignUpAttempt) {
    if ($signUpResult['isLoggedIn']) {
        $signupErrorMessage = $stringTable->lookup(EnginesisUIStrings::REGISTRATION_ACCEPTED);
    } else {
        $signupErrorMessage = $signUpResult['errorMessage'];
    }
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Sign up</h1>
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
