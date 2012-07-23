<?php
App::uses('Tenant', 'Model');

/**
 * Tenant Test Case
 *
 */
class TenantTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.tenant', 'app.user', 'app.roletype', 'app.profile');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tenant = ClassRegistry::init('Tenant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tenant);

		parent::tearDown();
	}

}
