<?php
/**
 * MenteeSurveyFixture
 *
 */
class MenteeSurveyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'date_sent' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'returned' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'date_returned' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'date_sent' => '2012-07-09',
			'returned' => 1,
			'date_returned' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-07-09 22:07:36',
			'modified' => '2012-07-09 22:07:36'
		),
	);
}
