<?php
if ( ! defined('INXYS_VERSION')) {
    define('INXYS_VERSION', '3.1.1');
}
define('INXYS_ADMIN_LOCK', false);
define('ADMIN_LOCK_MESSAGE', '<h3>The Information Exchange is OFFLINE</h3><p>The Information Exchange is currently OFFLINE, most probably due to server maintenance.<br>If you have an immediate need to change something please contact inXys support <a href="mailto:support@inxys.net">support@inxys.net</a>.</p>' );
if (INXYS_ADMIN_LOCK && $_SERVER['PHP_SELF'] != '/offline/index.php') {
    header ("Location: /offline/");
    exit(0);
}

function getServiceVersion() {
    return INXYS_VERSION;
}
