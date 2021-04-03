<?php
include_once('../../services/inxys_common.php');
$pageId = 'about';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all.';
$loggedIn = false;

if ( ! $loggedIn) {
    $allToActionButton = ' <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a>';
} else {
    $allToActionButton = '';
}
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Information Exchange Help</h1>
    <p>
        Having trouble with our system? Use the material here to get the answers you need.
    </p>
    <div class="panel">
        <h2>Frequently asked questions</h2>
        <p>What do you want to know?.</p>
    </div>
    <p>
        <a href="/terms/" target="_new" class="right">Terms of service</a> |
        <a href="/privacy/" target="_new" class="right">Privacy policy</a>
    </p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>