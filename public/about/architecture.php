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
    <h1>Conference system information architecture</h1>
    <div class="panel">
        <p>
            The inXys information design is based on work done by Murray Turoff et al at NJIT related to <a href="http://ieeexplore.ieee.org/document/49267/" target="_blank">TEIES</a> and its predecessor <a href="https://en.wikipedia.org/wiki/Electronic_Information_Exchange_System" target="_blank">EIES</a>.
            The inXys information model is built around the core objects and the services that support them:
        <ul>
            <li>User</li>
            <li>Group</li>
            <li>Conference
                <ul>
                    <li>Membership</li>
                    <li>Topics
                        <ul>
                            <li>Comments
                                <ul>
                                    <li>Replies</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>Notification</li>
            <li>Ticket</li>
        </ul>
        </p>
            <p>
                A <strong>conference</strong> is a container of members (users and groups) and topics. A <strong>conference</strong> is an on-going, asynchronous discussion by users focused on a particular subject. A conference is a collection of <strong>Topics</strong>, each topic has <strong>comments</strong> made by users related to the topic. A comment may have user <strong>replies</strong>, furthering the discussion around that initial comment.
                <i>topics</i> are main tracts of discussion with comments. <i>Comments</i> are discussion around topics and members can <i>reply</i> to individual comments.
        </p>
        <p>
            In a typical <em>conference</em> organization, a <em>moderator</em> or moderators will determine the topics of discussion and post those to the group. Members can comment on the topics and carry discussion in a series of comments or with replies to comments.
        </p>
        <p>
            <em>Notifications</em> are short messages broadcast to users, groups, or conference memberships about events that occur throughout the system.
        </p>
        <p>
            <em>Tickets</em> are privilege overrides granted to a user or group to provide access to secure objects in the system.
        </p>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
