<?php
App::uses('AppModel', 'Model');
/**
 * MentorExtraInfo Model
 * 
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class MentorExtraInfo extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'mentor_extra_info';
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
		'date_joined' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Please enter the date that the mentor joined',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_joined'),                            
                        )
		),
                'agreement_signed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'MentorExtraInfo', 'agreement_signed', 'date_agreement_signed', 
                                'Please enter the date that the mentor signed the mentor\'s agreement'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,                            
                        )
		),
		'date_agreement_signed' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_agreement_signed'),
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MentorExtraInfo', 'agreement_signed', 'date_agreement_signed', 
                                'Please check the "Agreement Signed" box if the mentor has signed the mentor\'s agreement. Or leave the "Date Agreement Signed" field empty if not.'),
                        )
		),
		'trained' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'MentorExtraInfo', 'trained', 'date_trained', 
                                'Please enter the date that the mentor was trained'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,
                        )
		),
		'date_trained' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_trained'),
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MentorExtraInfo', 'trained', 'date_trained', 
                                'Please check the "Trained" box if the mentor has been trained. Or leave the "Date Trained" field empty if not.'),
                        )
		),
		'max_mentees' => array(
			'numeric' => array(
                                'rule' => array('numeric'),
				'message' => 'Please enter the number of mentees (1-10) that this mentor would like',
				//'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),

                        'atleastone' => array(
                            'rule' => array('comparison', '>', 0),
                            'message' => 'A mentor must want at least 1 mentee!',
                            'last' => true, // Stop validation after this rule
                        ),
                        'maxten' => array(
                            'rule' => array('comparison', '<=', 10),
                            'message' => 'A mentor shouldn\'t want more than 10 mentees!',
                            'last' => true, // Stop validation after this rule
                        )
		),
	);

        
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
