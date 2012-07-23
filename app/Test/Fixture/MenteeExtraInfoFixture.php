<?php
/**
 * MenteeExtraInfoFixture
 *
 */
class MenteeExtraInfoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'mentee_extra_info';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'date_joined' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'invoiced' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'date_invoiced' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'payment_received' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'date_payment_received' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id_UNIQUE' => array('column' => 'id', 'unique' => 1)),
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
			'user_id' => 1,
			'date_joined' => '2012-07-03',
			'invoiced' => 1,
			'date_invoiced' => '2012-07-03',
			'payment_received' => 1,
			'date_payment_received' => '2012-07-03',
			'created' => '2012-07-03 07:35:16',
			'modified' => '2012-07-03 07:35:16'
		),
	);
}
