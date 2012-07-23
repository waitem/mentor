<?php
/**
 * MentorExtraInfoFixture
 *
 */
class MentorExtraInfoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'mentor_extra_info';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'date_joined' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'trained' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'date_trained' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'max_mentees' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
			'date_joined' => '2012-07-05',
			'trained' => 1,
			'date_trained' => '2012-07-05',
			'max_mentees' => 1,
			'created' => '2012-07-05 17:18:41',
			'modified' => '2012-07-05 17:18:41'
		),
	);
}
