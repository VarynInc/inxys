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
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>About The Information Exchange</h1>
    <p>
        Following up on the work of the Electronic Information Exchange System (EIES) of the mid-1970s to early 1990s, inXys presents a communication model that is uncommon on the Internet today. Many of today's information systems follow the simple forum model that lends to a free-for-all discussion format.
        To offer an alternative to the forum model, inXys leverages what we had learned in our prior research of connectivity and information systems to create a better system.
    </p>
    <p>
        The Information Exchange is a public forum, open to all, based on the work originally done by Murray Turoff and Starr Roxanne Hiltz on the
        <a href="https://en.wikipedia.org/wiki/Electronic_Information_Exchange_System" target="_blank">Electronic Information Exchange System</a> and the many
        contributions by the staff of the <a href="https://library.njit.edu/archives/cccc-materials/" target="_blank">Computerized Conferencing and Communications Center</a>
        at <a href="https://www.njit.edu/" target="_blank">New Jersey Institute of Technology</a>.
    </p>
    <h2>Mission Statement</h2>
    <blockquote><i>
        Our mission is to facilitate the free exchange of ideas and a strong sense of community. We encourage diversity, inclusion, and respect for all.
    </i></blockquote>
    <p>
        We respect all ideas, all opinions, no matter the source. However, we will filter out deliberate acts of harm and deceit, no matter who authors it. Review our <a href="/terms/" title="Terms of service">Terms of service</a> regarding our content policy.
    </p>
    <h2>Join us</h2>
    <p>
        Create an account for free. You get one public conference with your free account.<?php echo($allToActionButton);?>
    </p>
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
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
