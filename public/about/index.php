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
    <h1>About The Information Exchange</h1>
    <p>
        The Information Exchange is a public forum, open to all, based on the work originally done by Murray Turoff and Starr Roxanne Hiltz on the
        <a href="https://en.wikipedia.org/wiki/Electronic_Information_Exchange_System">Electronic Information Exchange System</a> and the many
        contributions by the staff of the <a href="https://library.njit.edu/archives/cccc-materials/">Computerized Conferencing and Communications Center</a>
        at <a href="https://www.njit.edu/">New Jersey Institute of Technology</a>.
    </p>
    <h2>Mission Statement</h2>
    <blockquote><i>
        Facilitate the free exchange of ideas and a strong sense of community. We encourage diversity, inclusion, and respect for all.
    </i></blockquote>
    <p>
        We respect all ideas, all opinions, no matter the source. However, we will filter out deliberate acts of harm and deceit, no matter who authors it.
    </p>
    <p>Create an account for free. You get one public conference with your free account.<?php echo($allToActionButton);?></p>
    <p>
        See our <a href="/privacy/">privacy policy</a> and <a href="/terms/">terms of use</a>.
    </p>
    <h2>Learn more about inXys</h2>
    <ul>
        <li><a href="help.php">Help and support</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="architecture.php">Information architecture</a></li>
        <li><a href="markdown.php">Markdown guide</a></li>
    </ul>
    <p>
        <a href="/terms/" target="_new" class="right">Terms of service</a> |
        <a href="/privacy/" target="_new" class="right">Privacy policy</a>
    </p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>