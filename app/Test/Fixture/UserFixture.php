<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'tenant_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'roletype_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phone_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 1,
			'parent_id' => 1,
			'email' => 'superadmin@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Superadmin1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
		array(
			'id' => 2,
                        // Inactive !
			'active' => 0,
			'tenant_id' => 1,
			'roletype_id' => 2,
			'parent_id' => 1,
			'email' => 'admin1@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin1',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
                array(
			'id' => 3,
                        // Active admin
			'active' => 1,
			'tenant_id' => 1,
			'roletype_id' => 2,
			'parent_id' => 1,
			'email' => 'admin2@tenant1.com',
			'password' => '145bc85b1fc527ceb2b91bd308378bdcdc8d3dd3',
			'first_name' => 'Admin2',
			'last_name' => 'Tenant1',
			'phone_number' => '111 111',
			'created' => '2012-06-09 14:21:46',
			'modified' => '2012-06-09 14:21:46'
		),
	);
}
