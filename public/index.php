<?php
include_once('../sitedev/services/common.php');
$pageId = 'Conferences';
$pageTitle = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="jumbotron">
        <h1>The Information Exchange</h1>
        <p>This is what we are all about.</p>
        <p>Create an account for free. You get one public conference with your free account.</p>
        <p>
            <a class="btn btn-lg btn-primary" href="login.php" role="button">Log in &raquo;</a>
        </p>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>