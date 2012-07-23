<?php
App::uses('MenteeExtraInfo', 'Model');

/**
 * MenteeExtraInfo Test Case
 *
 */
class MenteeExtraInfoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.mentee_extra_info', 'app.user', 'app.tenant', 'app.roletype', 'app.profile');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MenteeExtraInfo = ClassRegistry::init('MenteeExtraInfo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MenteeExtraInfo);

		parent::tearDown();
	}

}
