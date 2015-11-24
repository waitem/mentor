<?php
//
//FIXME: Add tests for not set password  (add fixtures too!)
//
App::uses('UsersController', 'Controller');

/**
 * TestUsersController *
 */
class TestUsersControllerMentor extends UsersController {
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
class UsersControllerMentorTest extends ControllerTestCase {
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
		$this->Users = new TestUsersControllerMentor();
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

        /*
         * This gets run after the setUp
         */
	private function loginUser( $good_login_data, $user_id, $user_name ) {

            // Do a log-out before we try doing any login, just in case we are still logged in from a previous test
            $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));

            // Call up the login page (located at root URL!)
            $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="email" id="UserEmail" required="required"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword" required="required"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->contents);

            // Now try to log in with good credentials
            $this->testAction('/', array( 'data' => $good_login_data, 'return' => 'contents', 'method' => 'post'));
            // We should end up with null data as the redirect() function is mocked in testing
            $this->assertNull( $this->contents, '"contents" should be null - we are logged in but redirect does not do anything in testing');

            // Now try to pull up the user's home screen
            $this->testAction('/users/view/' . $user_id, array( 'return' => 'contents', 'method' => 'get'));
            // Make sure that we did not do something we were not allowed to do
            $this->assertTrue((preg_match('|\<div.*>Sorry, but you are not allowed to do that\</div>|', $this->contents) == 0),
                    "The message 'Sorry, but you are not allowed to do that' should not be shown");
            // Make sure that we have logged into the correct tenant
            $this->assertRegExp('|<title>[[:space:]]*' .
            		'Business Mentoring Tenant One[[:space:]]*' .
            		':[[:space:]]*' .
            		'My details[[:space:]]*' .
            		'</title>|',
            		$this->contents,
            		'Page title is incorrect - or wrong tenant?' );
            // And user
            $this->assertContains('<a href="/users/view/' . $user_id . '">' . $user_name . '</a>', $this->contents );

        }

       	private function loginAsMentor() {
        	
        		$good_login_data = array(
        				'User' => array(
        						'email' => 'mentor1@tenant1.com',
        						'password' => 'password'
        				)
        		);
        		$user_id = 7;
        		$user_name = "Mentor1 Tenant1";
        		
        		$this->loginUser( $good_login_data, $user_id, $user_name);
        		 
        }

        private function loginAsCoordinator() {
        	 
        	$good_login_data = array(
        			'User' => array(
        					'email' => 'coordinator1@tenant1.com',
        					'password' => 'password'
        			)
        	);
        	$user_id = 6;
        	$user_name = "Coordinator1 Tenant1";
        	
        	$this->loginUser( $good_login_data, $user_id, $user_name);
        	 
        }
        
        private function logoutUser() {
            // End the test by logging out
            $result = $this->testAction('/users/logout', array( 'return' => 'view', 'method' => 'get'));
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the session no longer has any tenant details
            $this->assertRegExp('|\<h1> *Business Mentoring Application *\</h1>|', $this->contents, 'Tenant has not been reset' );
        }

        private function changeMentorStatus( $user_data, $current_status_string, $new_status_string ) {
        	
        	//Now log in as coordinator
        	$this->loginAsCoordinator();
        	
        	// Now try to pull up a mentor's screen
        	$this->testAction('/users/view/7' , array( 'return' => 'contents', 'method' => 'get'));
        	
        	// Make sure that we did not do something we were not allowed to do
        	$this->assertTrue((preg_match('|\<div.*>Sorry, but you are not allowed to do that\</div>|', $this->contents) == 0),
        			"The message 'Sorry, but you are not allowed to do that' should not be shown");
        	 
        	// Check that the status is as it should be
        	$this->assertContains('<dt>Status</dt><dd>' . $current_status_string . '</dd><dt>', $this->contents,
        			'Mentor does not have status of "' . $current_status_string . '"');
        	
        	// Note that contents is only returned if the post fails because no redirect takes place
        	$result = $this->testAction('/users/edit/7',
        			array(
        					'data' => $user_data,
        					'return' => 'contents',
        					'method' => 'post'
        			)
        	);
        	
        	$error_message = 'Change mentor status to "' . $new_status_string . '"' ;
        	
        	if (is_string($this->contents)) {
        		$this->assertContains(
        				$user_data['User']['first_name'] . '\'s details could not be updated',
        				$this->contents,
        				$error_message
        		) ;
        	} else {
        		$this->assertTrue( is_null($this->contents), $error_message);
        	}
        	
        	// Now try to pull up the mentor's screen
        	$this->testAction('/users/view/7' , array( 'return' => 'contents', 'method' => 'get'));
        	// Check that it is now an inactive mentor as it should be
        	$this->assertContains('<dt>Status</dt><dd>' . $new_status_string . '</dd><dt>', $this->contents,
        			'Mentor does not have status of "' . $new_status_string . '"');
        	// log out as coordinator
        	$this->logoutUser();
        	 
        }
        
        public function testMentorDeactivatedOK() {

        	$first_name = 'Mentor1';
        	
        	$user_data = array(
        			'User' => array(
        					'id' => 7,
        					// the next two fields are required by the controller when
        					// handling posted edit data
        					'first_name' => $first_name,
        					'roletype_id' => 4,
        					'user_status_id' => 11, // Inactive mentor
        					// name is required if the post fails
        					'name' => 'Mentor1 Tenant1',
        					//
        					'parent_id' => 6
        			)
        	);
        	
        	// Check that we can log in as mentor
        	$this->loginAsMentor();
        	// log out again
        	$this->logoutUser();
        	
        	// Change the status to inactive
        	$this->changeMentorStatus( $user_data, 'Active Mentor' , 'Inactive' );
        	        	        	
        	// now try and log in as the mentor - it should fail
        	$good_login_data = array(
        			'User' => array(
        					'email' => 'mentor1@tenant1.com',
        					'password' => 'password'
        			)
        	);
        	// Now try to log in with bad credentials
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
        	
        	$result = $this->testAction('/', array( 'data' => $good_login_data, 'return' => 'contents', 'method' => 'post'));
        	
        	// We should end up with null data as the redirect() function is mocked in testing
        	$this->assertNull( $this->contents, '"contents" should be null - redirect does not do anything in testing');
        	        	
        	// Call up the login page (located at root URL!)
        	$result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
        	$this->assertContains('<div id="flashMessage" class="message">Sorry, your account is not (yet) activated, please contact the coordinator</div>', $this->contents);
        	
        	// now change the mentor's user status to an active one
        	$user_data['User']['user_status_id'] = 15; // Active mentor
        	
        	// Change the status back to active
        	$this->changeMentorStatus( $user_data, 'Inactive' , 'Active Mentor' );
        	
        	// Check that we can log in as mentor
        	$this->loginAsMentor();
        	// log out again
        	$this->logoutUser();

        }
}