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
        
        public function testLogin() {
             $data = array(
                'User' => array(
                    'email' => 'superadmin@mentor.com',
                    'password' => 'password'
                )
            );
            // Call up the login page (located at root URL!)
            $result = $this->testAction('/', array( 'return' => 'view', 'method' => 'get'));
            // Check that the e-mail input field is there
            $this->assertContains('<input name="data[User][email]" maxlength="255" type="text" id="UserEmail"/>', $this->view);
            // Check that the password input field is there
            $this->assertContains('<input name="data[User][password]" type="password" id="UserPassword"/>', $this->view);
            // Check that the submit button is there
            $this->assertContains('<button type="submit">Login</button>', $this->view);
            
            $result = $this->testAction('/', array( 'data' => $data, 'return' => 'view', 'method' => 'post'));
            debug($this->view);
        }
}
