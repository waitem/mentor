<?php
/**
 * InvoiceFixture
 *
 */
class InvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'invoice_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'date_invoiced' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => '	'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date_payment_received' => array('type' => 'date', 'null' => true, 'default' => null),
		'total_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'created' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'id_UNIQUE' => array('column' => 'id', 'unique' => 1)
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
			'invoice_number' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'date_invoiced' => '2013-03-09',
			'description' => 'Lorem ipsum dolor sit amet',
			'date_payment_received' => '2013-03-09',
			'total_amount' => 1,
			'created' => 1,
			'modified' => 1
		),
	);

}
