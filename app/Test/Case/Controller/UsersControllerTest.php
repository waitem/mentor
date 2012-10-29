<?php
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
	public $fixtures = array('app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentor_extra_info', 'app.mentee_extra_info', 'app.user_away_date', 'app.user_address');

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
            $this->assertRegExp('|\<h1> *Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="text" id="UserEmail"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->contents);
            debug($this->contents);
            
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again');
            $this->assertContains('Hmmm, something was wrong with your username or password', $this->contents );
            debug($this->contents);
            
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen
            $result = $this->testAction('/users/view/1', array( 'return' => 'contents', 'method' => 'get'));
            // Make sure that we have logged into the correct tenant
            $this->assertContains('Tenant One Business Mentors', $this->contents );
            // And user
            $this->assertContains('<a href="/mentor/users/view/1">Superadmin1 Tenant1</a>', $this->contents );
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
            $this->assertRegExp('|\<h1> *Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );            
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="text" id="UserEmail"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            debug($this->view);
            
            // Now try to log in with bad credentials
            $result = $this->testAction('/', array( 'data' => $bad_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with the login screen again
            $this->assertNotNull( $this->contents, '"contents" should be not null - it should contain the login screen again');
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
        
        public function testActiveAdminLogin() {
            $good_data = array(
                'User' => array(
                    'email' => 'admin2@tenant1.com',
                    'password' => 'password'
                )
            );
            
            $bad_data = array(
                'User' => array(
                    'email' => 'admn2@tenant1.com',
                    'password' => 'password'
                )
            );
            
            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );            
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="text" id="UserEmail"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            debug($this->view);
                        
            // Now try to log in with good credentials
            $result = $this->testAction('/', array( 'data' => $good_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');            

            // Now try to pull up the user's home screen
            $result = $this->testAction('/users/view/3', array( 'return' => 'contents', 'method' => 'get'));
            
            // Make sure that we have logged into the correct tenant
            $this->assertContains('Tenant One Business Mentors', $this->contents );
            // And user
            $this->assertContains('<a href="/mentor/users/view/3">Admin2 Tenant1</a>', $this->contents );
            debug($this->contents);
            
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));            
            
        }
}
