<?php
App::uses('MenteeSurvey', 'Model');

/**
 * MenteeSurvey Test Case
 *
 */
class MenteeSurveyTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.mentee_survey', 'app.user', 'app.tenant', 'app.roletype', 'app.profile', 'app.mentor_extra_info', 'app.mentee_extra_info', 'app.user_away_date');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MenteeSurvey = ClassRegistry::init('MenteeSurvey');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MenteeSurvey);

		parent::tearDown();
	}

}
