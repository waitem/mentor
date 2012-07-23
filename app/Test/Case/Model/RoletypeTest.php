<?php
App::uses('Roletype', 'Model');

/**
 * Roletype Test Case
 *
 */
class RoletypeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.roletype', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Roletype = ClassRegistry::init('Roletype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Roletype);

		parent::tearDown();
	}

}
