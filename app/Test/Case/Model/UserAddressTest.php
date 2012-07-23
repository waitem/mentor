<?php
App::uses('UserAddress', 'Model');

/**
 * UserAddress Test Case
 *
 */
class UserAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_address',
		'app.user',
		'app.tenant',
		'app.roletype',
		'app.profile',
		'app.mentor_extra_info',
		'app.mentee_extra_info',
		'app.user_away_date'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAddress = ClassRegistry::init('UserAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAddress);

		parent::tearDown();
	}

}
