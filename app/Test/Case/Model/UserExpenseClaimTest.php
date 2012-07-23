<?php
App::uses('UserExpenseClaim', 'Model');

/**
 * UserExpenseClaim Test Case
 *
 */
class UserExpenseClaimTestCase extends CakeTestCase {
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
		$this->UserExpenseClaim = ClassRegistry::init('UserExpenseClaim');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserExpenseClaim);

		parent::tearDown();
	}

}
