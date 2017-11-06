<?php
include_once('../../sitedev/services/common.php');
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
        Already a member? <a class="btn btn-primary" href="/" role="button">Log in &raquo;</a>
    </p>
    <p>
        Create an account for free. You get one public conference with your free account.
    </p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>