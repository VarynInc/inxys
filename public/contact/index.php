<?php
include_once('../../services/inxys_common.php');
$pageId = 'about';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage inclusion, diversity, and respect for all.';
$loggedIn = false;

if ( ! $loggedIn) {
    $allToActionButton = ' <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a>';
} else {
    $allToActionButton = '';
}
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Contact inXys.net support</h1>
    <div class="row justify-content-md-center">
        <div class="col col-md-4"></div>
        <div class="col col-md-4 align-self-center">
            <?php include(VIEWS_ROOT . 'contact.php');?>
        </div>
        <div class="col col-md-4"></div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
