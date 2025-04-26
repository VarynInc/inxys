<div>
    <?php
    if ( ! empty($loginErrorMessage)) {
        echo($loginErrorMessage);
    } elseif (isset($userInfo)) {
        echo('<h3>' . formattedUserName($userInfo) . '</h3>');
    }
    ?>
    User profile card
</div>
<div>
    Users online
</div>
<div>
    <h1>Recent notifications</h1>
    <p>No new notifications</p>
</div>
<div>
    <h1>Conference activity</h1>
    <p>No new activity</p>
</div>
