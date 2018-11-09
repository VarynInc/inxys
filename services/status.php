<?php
define('ADMIN_LOCK', false);
define('ADMIN_LOCK_MESSAGE', '<h3>The Information Exchange is OFFLINE</h3><p>The Information Exchange Platform is currently OFFLINE, most probably due to server maintenance.<br/>If you have an immediate need to change something please contact Enginesis support <a href="mailto:support@inxys.net">support@inxys.net</a>.</p>' );
if (ADMIN_LOCK && currentPageName() != 'offline') {
    header ("Location: /offline.php");
    exit(0);
}
