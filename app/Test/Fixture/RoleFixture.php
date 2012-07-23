<?php
/**
 * RoleFixture
 *
 */
class RoleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tenant_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'roletype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'One of:
Superadmin
Admin
Coordinator
Mentor
Mentee

Later enhancement:
Lookup from a separate
table e.g. roletypes'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'role_id of parent (if
applicable)'),
		'authorised' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'comment' => 'Must only be set to true by the "parent" or above
Initially false when a new user registers and selects their role'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id_UNIQUE' => array('column' => 'id', 'unique' => 1)),
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
			'tenant_id' => 1,
			'roletype_id' => 1,
			'user_id' => 1,
			'parent_id' => 1,
			'authorised' => 1,
			'created' => '2012-06-07 20:31:22',
			'modified' => '2012-06-07 20:31:22'
		),
	);
}
