<?php
//
//FIXME: Add tests for not set password  (add fixtures too!)
//
App::uses('UsersController', 'Controller');

/**
 * TestUsersController *
 */
class TestUsersController extends UsersController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentor_extra_info', 'app.mentee_extra_info', 'app.user_away_date', 'app.user_address',
			'app.user_status',
			'app.invoice',
                // The following two are needed to ensure that the audit tables exist
                'plugin.audit_log.audit',
                'plugin.audit_log.audit_delta'
            );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Users = new TestUsersController();
		$this->Users->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	// public function testIndex() {
            
	// }
/**
 * testView method
 *
 * @return void
 */
	//public function testView() {

	//}
/**
 * testAdd method
 *
 * @return void
 */
	//public function testAdd() {

	//}
/**
 * testEdit method
 *
 * @return void
 */
	//public function testEdit() {

	//}
/**
 * testDelete method
 *
 * @return void
 */
	//public function testDelete() {

	//}
        
        public function testSuperadminLogin() {
            $good_data = array(
                'User' => array(
                    'email' => 'superadmin@tenant1.com',
                    'password' => 'password'
                )
            );
            
            $bad_data = array(
                'User' => array(
                    'email' => 'speradmin@tenant1.com',
                    'password' => 'password'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="email" id="UserEmail" required="required"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword" required="required"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->contents);
            debug($this->contents);
            
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again because login should have failed');
            $this->assertContains('Hmmm, something was wrong with your username or password', $this->contents );
            debug($this->contents);
            
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen
            $result = $this->testAction('/users/view/1', array( 'return' => 'contents', 'method' => 'get'));
            // Make sure that we have logged into the correct tenant
            $this->assertRegExp('|<title>[[:space:]]*' .
            		'Business Mentoring Tenant One[[:space:]]*' .
            		':[[:space:]]*' .
            		'My details[[:space:]]*' .
            		'</title>|',
            		$this->contents,
            		'Page title is incorrect' );            
            
            // And user
            $this->assertContains('<a href="/users/view/1">Superadmin1 Tenant1</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            debug($this->view);
            
        }
        
        public function testInactiveAdminLogin() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin1@tenant1.com',
                    'password' => 'password'
                )
            );
            
            $bad_data = array(
                'User' => array(
                    'email' => 'admn1@tenant1.com',
                    'password' => 'password'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );            
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="email" id="UserEmail" required="required"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword" required="required"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            debug($this->view);
            
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again because login should have failed');
            $this->assertContains('Hmmm, something was wrong with your username or password', $this->contents );
            //debug($this->contents);
            
            // Now try to log in with good credentials - but account not active
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen - we should not be able to as the user is not active
            $result = $this->testAction('/users/view/2', array( 'return' => 'contents', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            $this->assertContains('<div id="flashMessage" class="message">Sorry, your account is not (yet) activated, please contact the coordinator</div>', $this->contents);
            //debug($this->contents);
            
        }
        
        public function testActiveAdminTenant1Login() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin2@tenant1.com',
                    'password' => 'password'
                )
            );
            
            $bad_data = array(
                'User' => array(
                    'email' => 'admin2@tenant1.com',
                    'password' => 'passwrd'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );            
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="email" id="UserEmail" required="required"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword" required="required"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            debug($this->view);
                        
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again because login should have failed');
            $this->assertContains('Hmmm, something was wrong with your username or password', $this->contents );
            debug($this->contents);
          
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen
            $result = $this->testAction('/users/view/3', array( 'return' => 'contents', 'method' => 'get'));
            
            // Make sure that we have logged into the correct tenant - and that the page title is correct
            $this->assertRegExp('|<title>[[:space:]]*' .
            		'Business Mentoring Tenant One[[:space:]]*' .
            		':[[:space:]]*' .
            		'My details[[:space:]]*' .
            		'</title>|',
            		$this->contents,
            		'Page title is incorrect' );
            
            // And user
            $this->assertContains('<a href="/users/view/3">Admin2 Tenant1</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));            
            
        }
        
        public function testActiveAdminTenant2Login() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin1@tenant2.com',
                    'password' => 'password'
                )
            );
            
            $bad_data = array(
                'User' => array(
                    'email' => 'admin1@tenant2.com',
                    'password' => 'passwrd'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|<h1>[[:space:]]*Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );            
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="email" id="UserEmail" required="required"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword" required="required"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            debug($this->view);
                        
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again because login should have failed');
            $this->assertContains('Hmmm, something was wrong with your username or password', $this->contents );
            debug($this->contents);
          
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen
            $result = $this->testAction('/users/view/4', array( 'return' => 'contents', 'method' => 'get'));
            
            // Make sure that we have logged into the correct tenant - and that the page title is correct 
			$this->assertRegExp('|<title>[[:space:]]*' .
					'Business Mentoring Tenant Two[[:space:]]*' .
					':[[:space:]]*' .
					'My details[[:space:]]*' .
					'</title>|',
					$this->contents,            		
            		'Page title is incorrect' );

            // And user
            $this->assertContains('<a href="/users/view/4">Admin1 Tenant2</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));            
            
        }        
        
        public function testAdminViewOtherTenantAdmin() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin1@tenant2.com',
                    'password' => 'password'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
                                  
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up an admin (id = 3) from another Tenant'shome screen
            $result = $this->testAction('/users/view/3', array( 'return' => 'contents', 'method' => 'get'));
            
            // Check that we were not allowed to see the admin from another tenant
            $this->assertContains('Sorry, but you are not allowed to do that', $this->contents, "Check that we cannot see an admin from another tenant" );
                        
            // Make sure that we have logged into the correct tenant - and that the page title is correct
            $this->assertRegExp('|<title>[[:space:]]*Business Mentoring Tenant Two[[:space:]]*:[[:space:]]*My details[[:space:]]*</title>|',
            		$this->contents,
            		'Page title is incorrect' );

            // And user
            $this->assertContains('<a href="/users/view/4">Admin1 Tenant2</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));            
            
        }  
        
        public function testAdminViewSameTenantAdmin() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin2@tenant2.com',
                    'password' => 'password'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
                                  
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up an admin (id = 4) from same Tenant
            $result = $this->testAction('/users/view/4', array( 'return' => 'contents', 'method' => 'get'));
            
            // Check that we are allowed to see the admin from same tenant
            $this->assertRegExp('|<title>[[:space:]]*' .
            		'Business Mentoring Tenant Two[[:space:]]*' .
            		':[[:space:]]*' .
            		'Admin1 Tenant2[[:space:]]*' .
            		'</title>|',
            		$this->contents,
            		'Other admin from same tenant should be shown' );

            // And link to "my" details
            $this->assertContains('<a href="/users/view/5">Admin2 Tenant2</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));            
            
        }  
}

