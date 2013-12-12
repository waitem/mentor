<?php
App::uses('AppModel', 'Model');
/**
 * UserAwayDate Model
 * 
 * Copyright (c) 2012-2013 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class UserAwayDate extends AppModel {
    
    public $actsAs = array(
            'AuditLog.Auditable' => array(
               'ignore' => array( 'modified', 'created' )
            )
        );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_day_away' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Please enter the first day that you will be away or unavailable',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInPast' => array(
                            'rule' => array( 'dateNotInPast', 'first_day_away'),
                        )
		),
		'last_day_away' => array(
			'date' => array(
				'rule' => array('date'),
                                'message' => 'Please enter the last day that you will be away or unavailable',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInPast' => array(
                            'rule' => array( 'dateNotInPast', 'last_day_away'),
                        ),
                        'dateSameOrLater' => array(
                            'rule' => array( 'dateSameOrLater', 'UserAwayDate', 'first_day_away', 'last_day_away'),
                            'message' => 'The last day must be after the first day',
                        )
		),
	);
        
        public function getDetails($id) {
                           
                // Now get some information about the user
         
                $details = UserAwayDate::find(
                                'all',
                                array(
                                  'conditions' => array(
                                      //Only for this user
                                      'UserAwayDate.user_id' => $id,
                                      // Only show dates which end on or after today
                                      'UserAwayDate.last_day_away >=' => date('Y-m-d'),
                                  ),
                                  // Sort by increasing start date
                                  'order' => 'UserAwayDate.first_day_away ASC'
                                )
                            );               
                return $details;
        }
        
        
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
