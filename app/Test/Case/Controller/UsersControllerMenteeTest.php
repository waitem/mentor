<?php
//
//FIXME: Add tests for not set password  (add fixtures too!)
//
App::uses('UsersController', 'Controller');

/**
 * TestUsersController *
 */
class TestUsersControllerMentee extends UsersController {
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
class UsersControllerMenteeTest extends ControllerTestCase {
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
		$this->Users = new TestUsersControllerMentee();
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
            $this->assertContains('<a href="/mentor/users/view/' . $user_id . '">' . $user_name . '</a>', $this->contents );

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


        public function testOneMentorAssigned() {

            $error_message = 'Save mentee with one mentor did not work as expected';
            
            $mentee_data = array(
                'User' => array(
                    'id' => 9,
                    // the next two fields are required by the controller when
                    // handling posted edit data
                    'first_name' => 'Mentee1',
                    'roletype_id' => 5,
                	'user_status_id' => 5, // Mentor assigned
                    // name is required if the post fails
                    'name' => 'Mentee1 Tenant1',
                    //
                    'parent_id' => 7,
                    'second_mentor_id' => 0,
                )
            );

            $this->loginAsCoordinator();

            // now try to edit a mentee
            $this->testAction('/users/edit/9', array( 'return' => 'contents', 'method' => 'get'));

            // Check that we are showing the mentee edit screen
            $this->assertRegExp('|<h2>[[:space:]]*Edit Mentee1 Tenant1\'s details \(Mentee\)[[:space:]]*\</h2>|', $this->contents, 'Not showing mentee edit screen' );

            // Try saving the mentee with one mentor - should be OK
            $this->testAction('/users/edit/9',
                    array(
                        'data' => $mentee_data,
                        'return' => 'contents',
                        'method' => 'post'
                        )
                    );

            $flash_message = $this->Users->Session->read('Message.flash.message');
            if (is_string($flash_message)) {
                $this->assertContains('Mentee1\'s details have been updated',
                    $flash_message,
                    $error_message );
            } else {
                $this->assertTrue( $flash_message, $error_message);
            }

            $this->logoutUser();

        }


        public function testTwoMentorsAssigned() {

            $error_message = 'Save mentee with two mentors did not work as expected';
            
            $mentee_data = array(
                'User' => array(
                    'id' => 9,
                    // the next two fields are required by the controller when
                    // handling posted edit data
                    'first_name' => 'Mentee1',
                    'roletype_id' => 5,  // MENTEE
                	'user_status_id' => 5, // Mentor assigned
                    // name is required if the post fails
                    'name' => 'Mentee1 Tenant1',
                    //
                    'parent_id' => 7,
                    'second_mentor_id' => 8,
                )
            );

            $this->loginAsCoordinator();

            // Try saving the mentee with two mentors - should be OK
            $this->testAction('/users/edit/9',
                    array(
                        'data' => $mentee_data,
                        'return' => 'contents',
                        'method' => 'post'
                        )
                    );

            $flash_message = $this->Users->Session->read('Message.flash.message');
            if (is_string($flash_message)) {
                $this->assertContains('Mentee1\'s details have been updated',
                    $flash_message,
                    $error_message );
            } else {
                $this->assertTrue( $flash_message, $error_message);
            }

            $this->logoutUser();

        }

        public function testNoMentorsAssigned() {

            $error_message = 'Save mentee with no mentors did not work as expected';
            
            $mentee_data = array(
                'User' => array(
                    'id' => 9,
                    // the next two fields are required by the controller when
                    // handling posted edit data
                    'first_name' => 'Mentee1',
                    'roletype_id' => 5,
                	'user_status_id' => 4, // Invoice paid
                    // name is required if the post fails
                    'name' => 'Mentee1 Tenant1',
                    //
                    'parent_id' => 0,
                    'second_mentor_id' => 0,
                )
            );

            $this->loginAsCoordinator();

            // Try saving the mentee with no mentors - should be OK
            $this->testAction('/users/edit/9',
                    array(
                        'data' => $mentee_data,
                        'return' => 'contents',
                        'method' => 'post'
                        )
                    );
            
            $flash_message = $this->Users->Session->read('Message.flash.message');
            if (is_string($flash_message)) {
                $this->assertContains('Mentee1\'s details have been updated',
                    $flash_message,
                    $error_message );
            } else {
                $this->assertTrue( $flash_message, $error_message);
            }

            $this->logoutUser();

        }

        public function testOnlySecondMentorFails() {

            $error_message = 'Save mentee with only a second mentor did not fail as expected';
            
            $mentee_data = array(
                'User' => array(
                    'id' => 9,
                    // the next two fields are required by the controller when
                    // handling posted edit data
                    'first_name' => 'Mentee1',
                    'roletype_id' => 5,
                	'user_status_id' => 5, // Mentor assigned
                    // name is required if the post fails
                    'name' => 'Mentee1 Tenant1',
                    //
                    'parent_id' => 0,
                    'second_mentor_id' => 8,
                )
            );

            $this->loginAsCoordinator();

            // Try saving the mentee with only a second mentor - should fail
            // Note that contents is only returned if the post fails because no redirect takes place
            $this->testAction('/users/edit/9',
                    array(
                        'data' => $mentee_data,
                        'return' => 'contents',
                        'method' => 'post'
                        )
                    );

            if (is_string($this->contents)) {
                $this->assertContains(
                        'Mentee1\'s details could not be updated',
                        $this->contents,
                        $error_message
                        ) ;
            } else {
                $this->assertTrue( $this->contents, $error_message);
            }


            $this->logoutUser();

        }

        public function testSecondMentorSameAsFirstFails() {

            $error_message = 'Save mentee with second mentor same as first did not fail as expected';
            
            $mentee_data = array(
                'User' => array(
                    'id' => 9,
                    // the next two fields are required by the controller when
                    // handling posted edit data
                    'first_name' => 'Mentee1',
                    'roletype_id' => 5,
                	'user_status_id' => 5, // Mentor assigned
                    // name is required if the post fails
                    'name' => 'Mentee1 Tenant1',
                    //
                    'parent_id' => 7,
                    'second_mentor_id' => 7,
                )
            );

            $this->loginAsCoordinator();

            // Try saving the mentee with only a second mentor - should fail
            // Note that contents is only returned if the post fails because no redirect takes place
            $this->testAction('/users/edit/9',
                    array(
                        'data' => $mentee_data,
                        'return' => 'contents',
                        'method' => 'post'
                        )
                    );

            if (is_string($this->contents)) {
                $this->assertContains(
                        'Mentee1\'s details could not be updated',
                        $this->contents,
                        $error_message
                        ) ;
            } else {
                $this->assertTrue( $this->contents, $error_message);
            }

            $this->logoutUser();

        }

}