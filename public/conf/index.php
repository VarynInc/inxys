<?php /** Conference landing page
 * Show the user a list of available conferences:
 * - if logged in, then list conference a member of, in order of most recent activity.
 * - if not logged in, show public conference list in order of most recent activity.
 */
include_once('../../services/inxys_common.php');
require_once('../../services/strings.php');
require_once('../../services/conference.php');
$pageId = 'conferences';
$pageSubId = 'list';
$pageTitle = 'inXys Conferences';
$hackerVerification = '';
$errorCode = EnginesisErrors::NO_ERROR;

$action = getPostOrRequestVar('action', '');

if ($isLoggedIn) {
} else {
}
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Conferences</h1>
    <?php
    if ($isLoggedIn) {
        $tags = '';
        $oneMonthAgo = 30 * 24 * 60 * 60;
        $startDate = dateToMySQLDate(time() - $oneMonthAgo, true);
        $endDate = dateToMySQLDate(null, true);
        $startItem = 1;
        $numItems = 50;
        $conferenceList = Conference::list($tags, $startDate, $endDate, $startItem, $numItems);
        if (count($conferenceList) < 1) {
            echo("<div><p>You have no recent activity to review.<p></div>");
        } else {
            echo("<div><h3>Recent activity:<h3></div>");
            forEach ($conferenceList as $conferenceDetails) {
                echo(Conference::renderConferenceCard($conferenceDetails));
            }
        }
    ?>
    <?php
    } else {
    ?>
    <div>
        <p>You can read public conferences. To participate, you must log in. Create an account for free. You get one public conference with your free account.</p>
        <p><a class="btn btn-primary" href="/signup/" role="button">Join us &raquo;</a> or <a class="btn btn-success" href="/" role="button">Log in &raquo;</a></p>
    </div>
    <?php
    }
    ?>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
