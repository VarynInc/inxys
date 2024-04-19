<?php
include_once('../services/inxys_common.php');
$pageId = 'home';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all.';
$hackerVerification = '';
$isLoggedIn = false;
include(VIEWS_ROOT . 'page-header.php');
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
        <div class="col-8 p-3 banner-light rounded-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1><img src="/assets/img/inxys-logo-96.png" width="80" height="80"> The Information Exchange</h1>
                </div>
                <div class="col-6">
                    <blockquote><i>
                    To facilitate the free exchange of ideas
                    and a strong sense of community.
                    Encourage diversity, inclusion,
                    and respect for all.
                    </i></blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col col-md-4"></div>
        <div class="col col-md-4 align-self-center">
            <?php include(VIEWS_ROOT . 'login.php');?>
        </div>
        <div class="col col-md-4"></div>
    </div>
    <div class="row justify-content-md-center">
        <p>
        Not a member? <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a>
        </p>
        <p>
            Create an account for free. You get one public conference with your free account.
        </p>
    </div>
    <?php
    }
    ?>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>