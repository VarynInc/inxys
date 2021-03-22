<?php
include_once('common.php');

// Global variables that should be defined on every page
$pageId = '';         // Every page has an id so we can do per-page logic inside common functions
$pageTitle = '';      // Every page has a title, many times this is dynamically generated
$allMenuPages = array(array('id' => 'home', 'name' => 'Home', 'path' => '/'),
                      array('id' => 'conferences', 'name' => 'Conferences', 'path' => '/conf/'),
                      array('id' => 'users', 'name' => 'Users', 'path' => '/users/'),
                      array('id' => 'groups', 'name' => 'Groups', 'path' => '/groups/'),
                      array('id' => 'profile', 'name' => 'Profile', 'path' => 'profile.php'));
$isLoggedIn = false;  // true when we have a user logged in
$userId = 0;          // when logged in, this is the id of the logged in user
$serverName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'inxys-l.com');
$serverStage = '';    // One of our server stages: -l, -d, -q, -x. Empty for the production server.

function isActivePage($pageId) {
    global $allMenuPages;
    return in_array($pageId, $allMenuPages) ? 'active' : '';
}
