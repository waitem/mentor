<?php
App::uses('EmailConfig', 'Model');

/**
 * EmailConfig Test Case
 *
 */
class EmailConfigTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.email_config',
		'app.tenant',
		'app.user',
		'app.roletype',
		'app.profile',
		'app.user_address',
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
		$this->EmailConfig = ClassRegistry::init('EmailConfig');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EmailConfig);

		parent::tearDown();
	}

}
