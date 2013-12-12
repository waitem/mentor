<?php
/**
 * EmailConfigFixture
 *
 */
class EmailConfigFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'tenant_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'from_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'from_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sender_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sender_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_port' => array('type' => 'integer', 'null' => true, 'default' => null),
		'host_username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'host_password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'id_UNIQUE' => array('column' => 'id', 'unique' => 1),
			'tenant_id_UNIQUE' => array('column' => 'tenant_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
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
			'name' => 'Lorem ipsum dolor sit amet',
			'from_email' => 'Lorem ipsum dolor sit amet',
			'from_name' => 'Lorem ipsum dolor sit amet',
			'sender_email' => 'Lorem ipsum dolor sit amet',
			'sender_name' => 'Lorem ipsum dolor sit amet',
			'host_name' => 'Lorem ipsum dolor sit amet',
			'host_port' => 1,
			'host_username' => 'Lorem ipsum dolor sit amet',
			'host_password' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-01-04 18:02:41',
			'modified' => '2013-01-04 18:02:41'
		),
	);

}
