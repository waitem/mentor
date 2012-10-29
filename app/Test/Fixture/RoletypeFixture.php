<?php
/**
 * RoletypeFixture
 *
 */
class RoletypeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'importance' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'Lower number means
more important'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id_UNIQUE' => array('column' => 'id', 'unique' => 1), 'name_UNIQUE' => array('column' => 'name', 'unique' => 1)),
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
			'name' => 'Superadmin',
			'importance' => 10,
			'created' => '2012-06-09 14:09:31',
			'modified' => '2012-06-09 14:09:31'
		),
                array(
			'id' => 2,
			'name' => 'Admin',
			'importance' => 20,
			'created' => '2012-06-09 14:09:31',
			'modified' => '2012-06-09 14:09:31'
		),
                array(
			'id' => 3,
			'name' => 'Coordinator',
			'importance' => 30,
			'created' => '2012-06-09 14:09:31',
			'modified' => '2012-06-09 14:09:31'
		),
                array(
			'id' => 4,
			'name' => 'Mentor',
			'importance' => 40,
			'created' => '2012-06-09 14:09:31',
			'modified' => '2012-06-09 14:09:31'
		),
                array(
			'id' => 5,
			'name' => 'Mentee',
			'importance' => 50,
			'created' => '2012-06-09 14:09:31',
			'modified' => '2012-06-09 14:09:31'
		),            
	);
}
