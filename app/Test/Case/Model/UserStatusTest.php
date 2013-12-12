<?php
App::uses('UserStatus', 'Model');

/**
 * UserStatus Test Case
 *
 */
class UserStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserStatus = ClassRegistry::init('UserStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserStatus);

		parent::tearDown();
	}

}
