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
    <h1>Conference system information architecture</h1>
    <div class="panel">
        <p>
            The inxys information design is based on work done by Murray Turoff at NJIT related to <a href="http://ieeexplore.ieee.org/document/49267/">TEIES</a>.
            A <i>conference</i> is a container of members and topics, <i>topics</i> are main tracts of discussion with comments. <i>Comments</i> are discussion around topics and members can <i>reply</i> to individual comments.
                <ul>
                    <li>Conference
                    <ul>
                        <li>Members</li>
                        <li>Topics
                        <ul>
                            <li>Replies (replies directly to topics)</li>
                            <li>Comments
                            <ul>
                                <li>Replies</li>
                            </ul></li>
                        </ul></li>
                    </ul></li>
                </ul>
        </p>
        <p>
            In a typical conference organization, a <i>moderator</i> will determine the topics of discussion and post those to the group. Members can comment on the topics and carry discussion in a series of comments or with replies to comments.
        </p>
    </div>
    <p>
        <a href="/terms/" target="_new" class="right">Terms of service</a> |
        <a href="/privacy/" target="_new" class="right">Privacy policy</a>
    </p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>