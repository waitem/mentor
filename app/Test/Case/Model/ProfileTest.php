<?php
App::uses('Profile', 'Model');

/**
 * Profile Test Case
 *
 */
class ProfileTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.profile', 'app.user', 'app.tenant', 'app.role', 'app.roletype');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Profile = ClassRegistry::init('Profile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Profile);

		parent::tearDown();
	}

}
