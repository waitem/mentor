<?php
App::uses('AuditDelta', 'Model');

/**
 * AuditDelta Test Case
 *
 */
class AuditDeltaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.audit_delta',
		'app.audit',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AuditDelta = ClassRegistry::init('AuditDelta');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AuditDelta);

		parent::tearDown();
	}

}
