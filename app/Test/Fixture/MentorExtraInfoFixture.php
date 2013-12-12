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
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'MentorExtraInfo');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'user_id' => '7',
			'date_joined' => '2011-11-11',
			'trained' => 1,
			'agreement_signed' => 0,
			'date_agreement_signed' => null,
			'date_trained' => '2011-12-07',
			'max_mentees' => '2',
			'created' => '2012-07-05 17:46:12',
			'modified' => '2013-03-30 14:06:08'
		),
	);

}
