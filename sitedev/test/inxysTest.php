<?php
/* This test suite is designed to unit test all of the common.php functions.
 * Uses PHPUnit to unit test. See https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html
 * Run this test by itself with
 * phpunit ./inxysTest.php > test-results-inxys.log
 */
declare(strict_types=1);
global $enginesisLogger;

require_once('../../services/common.php');
require_once('../../services/EnginesisErrors.php');
require_once('../../services/Enginesis.php');

// function getallheaders does not exist when running PHP Unit :(
if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

use PHPUnit\Framework\TestCase;

final class inxysTest extends TestCase {
    public static $setup;
    protected $stage;
    protected $insecureHost;
    protected $secureHost;
    protected $site_id;
    protected $user_id;
    protected $language_code;
    protected $site_user_id;
    protected $network_id;
    protected $user_name;
    protected $access_level;

    /**
     * Initial test setup
     */
    public static function setUpBeforeClass(): void {
        self::$setup = false;
    }

    protected function setUp (): void {
        $this->stage = serverStage();
        if ( ! self::$setup) {
            // Do one-time setup here
            self::$setup = true;
            if ($this->stage == '') {
                die("You cannot run this on the Live server. Please only run the services test on a -l/-d/-q instance.");
            }
            ini_set('memory_limit', '32M');
            set_time_limit(280);
            $runDate = date('l F jS Y h:i:s A');
            $_SERVER['DOCUMENT_ROOT'] = '../../public';
            $this->insecureHost = 'https://enginesis' . $this->stage . '.com/index.php';	// define testing server for nonsecure and authenticated procedures
            $this->secureHost = 'https://private.enginesis' . $this->stage . '.com/index.php';	// define testing server for secure procedures
            echo("\n*** inXys regression test starting $runDate on stage=$this->stage, insecureHost=$this->insecureHost, secureHost=$this->secureHost ***\n\n");
        }
    }

    /**
     * Set of tests to verify serverConfig.php is setup correctly for this server.
     */
    public function testServerConfig () {
        global $siteId;
        global $languageCode;
        global $CMSUserLogins;
        global $_MEMCACHE_HOSTS;
        global $_MAIL_HOSTS;
        global $admin_notification_list;

        $this->assertEquals(ENGINESIS_SITE_ID, 109, "verify correct site id");
        $this->assertEquals($siteId, ENGINESIS_SITE_ID, "verify correct site id");
        $this->assertNotNull($languageCode, "verify language code assigned");
        $this->assertNotEmpty($CMSUserLogins, "verify CMS user");

        $this->assertTrue(defined('ENGINESIS_SITE_KEY'));
        $this->assertTrue(defined('SITE_SESSION_COOKIE'));
        $this->assertTrue(defined('ENGINESIS_SITE_NAME'));
        $this->assertTrue(defined('ENGINESIS_SITE_DOMAIN'));
        $this->assertEquals(ENGINESIS_SITE_DOMAIN, 'inxys.net');
        $this->assertTrue(defined('DEBUG_ACTIVE'));
        $this->assertTrue(defined('DEBUG_SESSION'));
        $this->assertTrue(defined('PUBLISHING_MASTER_PASSWORD'));
        $this->assertGreaterThan(5, strlen(PUBLISHING_MASTER_PASSWORD));
        $this->assertTrue(defined('SESSION_REFRESH_HOURS'));
        $this->assertGreaterThan(8, SESSION_REFRESH_HOURS);
        $this->assertTrue(defined('SESSION_REFRESH_INTERVAL'));
        $this->assertTrue(defined('ENGINESIS_CMS_API_KEY'));
        $this->assertGreaterThan(15, strlen(ENGINESIS_CMS_API_KEY));
        $this->assertTrue(defined('ENGINESIS_DEVELOPER_API_KEY'));
        $this->assertGreaterThan(15, strlen(ENGINESIS_DEVELOPER_API_KEY));
        $this->assertTrue(defined('SESSION_AUTHTOKEN'));
        $this->assertTrue(defined('SESSION_PARAM_CACHE'));

        $serverStage = serverStage();
        $result = is_array($_MEMCACHE_HOSTS);
        $this->assertTrue($result);
        $result = count($_MEMCACHE_HOSTS) > 0;
        $this->assertTrue($result);
        $result = is_array($_MEMCACHE_HOSTS[$serverStage]);
        $this->assertTrue($result);
        $result = strlen($_MEMCACHE_HOSTS[$serverStage]['host']) > 0;
        $this->assertTrue($result);
        $result = $_MEMCACHE_HOSTS[$serverStage]['port'];
        $this->assertGreaterThan(0, $result);

        $sslCertificate = dirname(__FILE__) . '/../../private/cacert.pem';
        $this->assertTrue(file_exists($sslCertificate), 'File does not exist ' . $sslCertificate);

        $result = is_array($_MAIL_HOSTS);
        $this->assertTrue($result);
        $result = count($_MAIL_HOSTS) > 0;
        $this->assertTrue($result);
        $mailHost = $_MAIL_HOSTS[$serverStage];
        $result = is_array($mailHost);
        $this->assertTrue($result);
        $result = count($mailHost) > 0;
        $this->assertTrue($result);
        $result = isset($mailHost['domain']);
        $this->assertTrue($result);
        $result = isset($mailHost['host']);
        $this->assertTrue($result);
        $result = isset($mailHost['port']);
        $this->assertTrue($result);
        $result = isset($mailHost['ssl']);
        $this->assertTrue($result);
        $result = isset($mailHost['tls']);
        $this->assertTrue($result);
        $result = isset($mailHost['user']);
        $this->assertTrue($result);
        $result = isset($mailHost['password']);
        $this->assertTrue($result);
        $result = isset($mailHost['apikey']);
        $this->assertTrue($result);

        $result = is_array($admin_notification_list);
        $this->assertTrue($result);
        $result = count($admin_notification_list) > 0;
        $this->assertTrue($result);
        for ($i = 0; $i < count($admin_notification_list); $i ++) {
            $result = checkEmailAddress($admin_notification_list[$i]);
            $this->assertTrue($result);
        }
    }

    /**
     * Verify logging system is working
     */
    public function testEnginesisLogging() {
        $enginesisLogger = new LogMessage([
            'log_active' => true,
            'log_level' => LogMessageLevel::All,
            'log_to_output' => false,
            'log_to_file' => true,
            'log_file_path' => SERVER_DATA_PATH
        ]);
        $this->assertTrue($enginesisLogger->isValid());
        $enginesisLogger->log("Test log message from Unit Test", LogMessageLevel::Error, 'System', __FILE__, __LINE__);
    }

    /**
     * Verify the assumptions about who and where we are are correct.
     */
    public function testServerStage() {
        $result = getCurrentDomain();
        $this->assertEquals('http://inxys-l.net', $result);
    }

    /**
     * Verify we are able to connect with Enginesis
     */
    public function testCallEnginesisAPI() {
        global $CMSUserLogins;

        $enginesis = new Enginesis(ENGINESIS_SITE_ID, '-l', ENGINESIS_DEVELOPER_API_KEY, 'reportError');
        $this->assertNotNull($enginesis);
        $enginesis->setCMSKey(ENGINESIS_CMS_API_KEY, $CMSUserLogins[0]['user_name'], $CMSUserLogins[0]['password']);
        $serverName = $enginesis->getServerName();
        $this->assertNotNull($serverName);
        $this->assertEquals(serverStage(), $enginesis->getServerStage());
        $serverStage = $enginesis->getServerStage();
        $this->assertNotEmpty($serverStage);
        $enginesisServer = $enginesis->getServiceRoot();
        $this->assertNotNull($enginesisServer);

        $siteInfo = $enginesis->siteGet(ENGINESIS_SITE_ID);
        $this->assertNotNull($siteInfo);
        $this->assertEquals(ENGINESIS_SITE_ID, $siteInfo->site_id);
        $this->assertEquals('inXys', $siteInfo->site_name);
    }
}
