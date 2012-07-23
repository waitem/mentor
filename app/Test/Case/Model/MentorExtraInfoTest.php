<?php
App::uses('MentorExtraInfo', 'Model');

/**
 * MentorExtraInfo Test Case
 *
 */
class MentorExtraInfoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.mentor_extra_info', 'app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentee_extra_info');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MentorExtraInfo = ClassRegistry::init('MentorExtraInfo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MentorExtraInfo);

		parent::tearDown();
	}

}
