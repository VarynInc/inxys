<?php /** config.php -- Global configuration constants
 * This file has per-server specific parameters and is not to be checked in for source control.
 * You must first include common.php in order to define certain global variables.
 */

define('DEBUG_ACTIVE', true);
define('DEBUG_SESSION', true);

// memcache access global table
$_MEMCACHE_HOSTS = array(	'-l'  => array('port'=>11215, 'host'=>'localhost'),
    '-d'  => array('port'=>11215, 'host'=>'www.inxys-d.net'),
    '-q'  => array('port'=>11215, 'host'=>'www.inxys-q.net'),
    '-x'  => array('port'=>11215, 'host'=>'www.inxys-x.net'),
    ''    => array('port'=>11215, 'host'=>'www.inxys.net'));

// $sqlDBs is an array of available databases using a key to determine which database is used for certain purposes.
// It is designed to proxy multiple databases (such as game data, users, metrics, ads) but as of this implementation
// we are storing everything in one single database.
$sqlDBs = null;
switch($serverStage) {
    case '-d':	// dev
        $sqlDBs = array(
            'inxys' => array(
                'host' => '563ea8ee5998e517545f54c2de979c7d6f026731.rackspaceclouddb.com',
                'port' => '3306',
                'user' => 'inxys',
                'password' => 'hamsters@R3cute',
                'db' => 'inxys-d'
            )
        );
        break;
    case '-q':	// qa
        $sqlDBs = array(
            'inxys' => array(
                'host' => '563ea8ee5998e517545f54c2de979c7d6f026731.rackspaceclouddb.com',
                'port' => '3306',
                'user' => 'inxys',
                'password' => 'hamsters@R3cute',
                'db' => 'inxys-q'
            )
        );
        break;
    case '-l':	// localhost
        $sqlDBs = array(
            'inxys' => array(
                'host' => '127.0.0.1',
                'port' => '3306',
                'user' => 'inxys',
                'password' => 'hamsters@R3cute',
                'db' => 'inxys'
            )
        );
        break;
    case '-x':	// external dev
        $sqlDBs = array(
            'inxys' => array(
                'host' => 'localhost',
                'port' => '3306',
                'user' => 'inxys',
                'password' => 'xxxxx',
                'db' => 'inxys'
            )
        );
        break;
    default:	// live
        $sqlDBs = array(
            'inxys' => array(
                'host' => '563ea8ee5998e517545f54c2de979c7d6f026731.rackspaceclouddb.com',
                'port' => '3306',
                'user' => 'inxys',
                'password' => 'hamsters@R3cute',
                'db' => 'inxys'
            )
        );
        break;
}

// Mail/sendmail/Postfix/Mailgun config
$_MAIL_HOSTS = array(
    '-l' => array('domain' => 'inxys-l.net', 'host' => 'smtp.verizon.net', 'port' => 465, 'ssl' => true, 'tls' => false, 'user' => 'jlf990@verizon.net', 'password' => 'xxx', 'apikey' => ''),
    '-d' => array('domain' => 'mailer.inxys-q.net', 'host' => 'smtp.mailgun.org', 'port' => 587, 'ssl' => false, 'tls' => true, 'user' => 'postmaster@mailer.inxys-q.net', 'password' => 'PAcJDDiMC04Zvt', 'apikey' => 'key-d0c39872a923eeb8f26b33d569575935'),
    '-q' => array('domain' => 'mailer.inxys-q.net', 'host' => 'smtp.mailgun.org', 'port' => 587, 'ssl' => false, 'tls' => true, 'user' => 'postmaster@mailer.inxys-q.net', 'password' => 'PAcJDDiMC04Zvt', 'apikey' => 'key-d0c39872a923eeb8f26b33d569575935'),
    '-x' => array('domain' => 'inxys-x.net', 'host' => 'smtpout.secureserver.net', 'port' => 25, 'ssl' => false, 'tls' => false, 'user' => '', 'password' => '', 'apikey' => ''),
    ''   => array('domain' => 'mailer.inxys.net', 'host' => 'smtp.mailgun.org', 'port' => 587, 'ssl' => false, 'tls' => true, 'user' => 'postmaster@mailer.inxys.net', 'password' => 'PAcJDDiMC04Zvt', 'apikey' => 'key-d0c39872a923eeb8f26b33d569575935')
);
ini_set('SMTP', $_MAIL_HOSTS[$serverStage]['host']);

// Define a list of email addresses who will get notifications of internal bug reports
$admin_notification_list = array('support@inxys.net', 'support@varyn.com', 'john@varyn.com', 'jlf990@gmail.com');
