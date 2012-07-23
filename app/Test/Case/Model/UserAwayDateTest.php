<?php
App::uses('UserAwayDate', 'Model');

/**
 * UserAwayDate Test Case
 *
 */
class UserAwayDateTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.user_away_date', 'app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentor_extra_info', 'app.mentee_extra_info');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAwayDate = ClassRegistry::init('UserAwayDate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAwayDate);

		parent::tearDown();
	}

}
