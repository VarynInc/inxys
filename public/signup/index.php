<?php
include_once('../../services/common.php');
$pageId = 'signup';
$pageTitle = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Sign up</h1>
    <div class="row justify-content-md-center">
        <div class="col col-md-4"></div>
        <div class="col col-md-4 align-self-center">
            <?php include(VIEWS_ROOT . 'signup.php');?>
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
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>