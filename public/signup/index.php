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
        you will receive an email be asking you to confirm your email address. You accouint is not active until you complete
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
<script>
    // @todo: onchange handler for name, password, email, to remove class "login-form-input-error"
    // @todo: onchange handler for username to check if available
    // @todo: button handler for show password toggle
    /**
     * On change handler for the user name field on a registration form.
     * Try to make sure the user name is not already registered to another account.
     * @param {object} element that is changing.
     * @param {string} domIdImage id that will receive update of name status either acceptable or unacceptable.
     */
    function onChangeUserName (element, domIdImage) {
        element.classList.remove("login-form-input-error");
        if ( ! waitingForUserNameReply && element != null) {
            if (element.target != null) {
                element = element.target;
            }
            if (domIdImage == null) {
                domIdImage = element.dataset.target;
            }
            const userName = element.value.toString();
            if (userName && varynApp.isValidUserName(userName)) {
                waitingForUserNameReply = true;
                domImage = domIdImage;
                enginesis.userGetByName(userName, onChangeUserNameServerResponse);
            } else {
                setUserNameIsUnique(domIdImage, false);
            }
        }
    }

    function onChangeUserNameServerResponse (enginesisResponse) {
        var userNameAlreadyExists = false;
        waitingForUserNameReply = false;
        if (enginesisResponse != null && enginesisResponse.fn != null) {
            userNameAlreadyExists = enginesisResponse.results.status.success == "1";
        }
        setUserNameIsUnique(domImage, ! userNameAlreadyExists);
        domImage = null;
    }

    /**
     * When we dynamically query the server to determine if the user name is a unique selection
     * use this function to indicate uniqueness result on the form.
     * @param {string} id for which DOM element we wish to manipulate.
     * @param {boolean} isUnique true if the name is unique, false if it is taken by someone else.
     */
    function setUserNameIsUnique (id, isUnique) {
        if (id) {
            var element = document.getElementById(id);
            if (element != null) {
                if (isUnique) {
                    element.classList.remove('username-is-not-unique');
                    element.classList.add('username-is-unique');
                    element.style.display = "inline-block";
                } else {
                    element.classList.remove('username-is-unique');
                    element.classList.add('username-is-not-unique');
                    element.style.display = "inline-block";
                }
            }
        }
    }

    function setupUserNameChangeHandler () {
        const registerFormUserName = document.getElementById("signup-username");
        if (registerFormUserName != null) {
            registerFormUserName.addEventListener("change", onChangeRegisterUserName);
            registerFormUserName.addEventListener("input", onChangeRegisterUserName);
            registerFormUserName.addEventListener("propertychange", onChangeRegisterUserName);
            setupRegisterUserNameOnChangeHandler();
            onChangeRegisterUserName(registerFormUserName, "signup-email"); // in case field is pre-populated
            const emailFormField = document.getElementById("signup-email");
            if (emailFormField != null) {
                emailFormField.addEventListener("change", onChangeEmail);
                emailFormField.addEventListener("input", onChangeEmail);
            }
        }
    }

    function onClickRegisterShowPassword (event) {
        const passwordInput = document.getElementById("signup-password");
        const icon = document.getElementById("show-password-icon");
        const text = document.getElementById("show-password-text");
        const show = icon.classList.contains("iconEyeSlash");

        if (show) {
            passwordInput.type = 'password';
            icon.className = 'iconEye';
            text.innerText = 'Show';
        } else {
            passwordInput.type = 'text';
            icon.className = 'iconEyeSlash';
            text.innerText = 'Hide';
        }
    }

</script>
</body>
</html>
