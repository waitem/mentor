<?php
App::uses('UserExpenseClaimsController', 'Controller');

/**
 * TestUserExpenseClaimsController *
 */
class TestUserExpenseClaimsController extends UserExpenseClaimsController {
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
 * UserExpenseClaimsController Test Case
 *
 */
class UserExpenseClaimsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user_expense_claim', 'app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentor_extra_info', 'app.mentee_extra_info', 'app.user_away_date');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserExpenseClaims = new TestUserExpenseClaimsController();
		$this->UserExpenseClaims->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserExpenseClaims);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}
