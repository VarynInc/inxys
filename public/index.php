<?php
include_once('../services/inxys_common.php');
require_once('../services/strings.php');

$pageId = 'home';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage inclusion, diversity, and respect for all.';
$hackerVerification = '';
$isLoggedIn = false;
$isLogInAttempt = false;
$loginErrorMessage = '';
$errorParameter = '';
include(VIEWS_ROOT . 'page-header.php');
$userInfo = restoreLoggedInUser();
if ($userInfo != null) {
    $isLoggedIn = true;
} else {
    $loginResult = handleLoginAttempt(getPostVar('login-username'), getPostVar('login-password'), valueToBoolean(getPostVar('rememberme', false)));
    $isLogInAttempt = $loginResult['isLogInAttempt'];
    if ($isLogInAttempt) {
        if ($loginResult['isLoggedIn']) {
            $loginErrorMessage = 'You are logged in! ' . $loginResult['errorMessage'];
            $isLoggedIn = true;
        } else {
            $loginErrorMessage = $loginResult['errorMessage'];
            $errorParameter = 'login-username';
        }
    }
}
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <?php
    if ($isLoggedIn) {
        include(VIEWS_ROOT . 'homepage.php');
    } else {
    ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 banner-light rounded-3">
            <div class="row justify-content-center">
                <div class="col-12 hero-banner">
                    <h1><img src="/assets/inxys-logo-96.png" class="hero-logo"> The Information Exchange</h1>
                </div>
                <div class="col-10 col-lg-8">
                    <blockquote><i>
                    To facilitate the free exchange of ideas and a strong sense of community.
                    Encourage inclusion, diversity, and respect for all.
                    </i></blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-10 col-md-6 align-self-center">
            <?php if ($loginErrorMessage != '') {
                echo('<div class="modalMessageArea"><p class="text-error">' . $loginErrorMessage . '</p></div>');
            }
            include(VIEWS_ROOT . 'login.php');?>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <p>Not a member? <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a></p>
        <p>Create an account for free. You get one public conference with your free account.</p>
    </div>
    <?php
    }
    ?>
</div>
<?php include(VIEWS_ROOT . 'footer.php');
if ($isLogInAttempt && ! empty($errorParameter)) {
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
?>
<script src="/js/login.js" type="module"></script>
</body>
</html>
