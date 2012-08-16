<?php
App::uses('UserNote', 'Model');

/**
 * UserNote Test Case
 *
 */
class UserNoteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_note',
		'app.user',
		'app.tenant',
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
		$this->UserNote = ClassRegistry::init('UserNote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserNote);

		parent::tearDown();
	}

}
