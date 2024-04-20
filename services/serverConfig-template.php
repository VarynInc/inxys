<?php
/**
 * Define sensitive data in this configuration file. If serverConfig.php is missing, then it should
 * be setup like this.
 * User: jf
 * Date: Feb-13-2016
 */
date_default_timezone_set('America/New_York');
define('LOGFILE_PREFIX', 'inxys');
define('SITE_SESSION_COOKIE', 'inxysuser');
define('ENGINESIS_SITE_NAME', 'inXys');
define('ENGINESIS_SITE_ID', 109);
define('ENGINESIS_SITE_DOMAIN', 'inxys.net');
define('DEBUG_ACTIVE', false);
define('DEBUG_SESSION', false);
define('PUBLISHING_MASTER_PASSWORD', '');
define('REFRESH_TOKEN_KEY', '');
define('ENGINESIS_CMS_API_KEY', '');
define('ENGINESIS_DEVELOPER_API_KEY', '');
define('COREG_TOKEN_KEY', '');
define('SESSION_REFRESH_HOURS', 4380);     // refresh tokens are good for 6 months
define('SESSION_REFRESH_INTERVAL', 'P6M'); // refresh tokens are good for 6 months
define('SESSION_AUTHTOKEN', 'authtok');
define('SESSION_PARAM_CACHE', 'engsession_params');

// memcache access global table
$_MEMCACHE_HOSTS = [
    '-l'  => ['port'=>11215, 'host'=>'inxys-l.net'],
    '-d'  => ['port'=>11215, 'host'=>'inxys-d.net'],
    '-q'  => ['port'=>11215, 'host'=>'inxys-q.net'],
    '-x'  => ['port'=>11215, 'host'=>'inxys-x.net'],
    ''    => ['port'=>11215, 'host'=>'inxys.net']
];

// Define a list of email addresses who will get notifications of internal bug reports
$admin_notification_list = ['support@inxys.net'];

// Define which CMS users will act as site admin for secured requests:
$CMSUserLogins = [
    ['user_name' => '', 'user_id' => 0, 'password' => '']
];
    
// SSO network API keys for the inXys website app:
$socialServiceKeys = [
    2  => ['service' => 'Facebook', 'app_id' => '', 'app_secret' => '', 'admins' =>''],
    7  => ['service' => 'Google',   'app_id' => '', 'app_secret' => '', 'admins' =>''],
    11 => ['service' => 'Twitter',  'app_id' => '', 'app_secret' => '', 'admins' =>''],
    14 => ['service' => 'Apple',    'app_id' => '', 'app_secret' => '', 'admins' =>'']
];

// Define the mail hosts to connect to for mail transfer and dispatch:
$_MAIL_HOSTS = [
    '-l' => ['domain' => '', 'host' => '', 'port' => 465, 'ssl' => true, 'tls' => true, 'user' => '', 'password' => '', 'apikey' => ''],
    '-d' => ['domain' => '', 'host' => '', 'port' => 465, 'ssl' => true, 'tls' => true, 'user' => '', 'password' => '', 'apikey' => ''],
    '-q' => ['domain' => '', 'host' => '', 'port' => 465, 'ssl' => true, 'tls' => true, 'user' => '', 'password' => '', 'apikey' => ''],
    '-x' => ['domain' => '', 'host' => '', 'port' => 465, 'ssl' => true, 'tls' => true, 'user' => '', 'password' => '', 'apikey' => ''],
    ''   => ['domain' => '', 'host' => '', 'port' => 465, 'ssl' => true, 'tls' => true, 'user' => '', 'password' => '', 'apikey' => '']
];

// Global variables:
$siteId = ENGINESIS_SITE_ID;
$languageCode = 'en';
