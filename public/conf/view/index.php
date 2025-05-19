<?php /** View and participate in a conference.
 * If no user is logged in and the conference is public, the user can read only.
 * If a user is logged in then the functions available depend on the user's role in the conference membership.
 */
include_once('../../../services/inxys_common.php');
$pageId = 'conference_view';
$pageTitle = '';
$hackerVerification = '';
$conferenceId = 'C103';
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Conference <?php echo($conferenceId);?></h1>
    <?php
    echo("<p>sluggify('thisisatest') = " . stringToSlug('thisisatest') . "</p>");
    echo("<p>sluggify('thisis@@@test') = " . stringToSlug('thisis@@@test') . "</p>");
    echo("<p>sluggify('this is a test') = " . stringToSlug('this is a test') . "</p>");
    echo("<p>sluggify('  this is a    test  ') = " . stringToSlug('  this is a    test  ') . "</p>");
    echo("<p>sluggify('  th56%^&@3is is # a  $$$  test  ///') = " . stringToSlug('  th56%^&@3is is # a  $$$  test  ///') . "</p>");
    if ($isLoggedIn) {
    ?>
    <?php
    } else {
    ?>
    <div>
        <p>You can read this conferences because it is public. To participate, you must log in. Create an account for free. You get one public conference with your free account.</p>
        <p><a class="btn btn-primary" href="/signup/" role="button">Join us &raquo;</a> or <a class="btn btn-success" href="/" role="button">Log in &raquo;</a></p>
    </div>
    <?php
    }
    ?>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
