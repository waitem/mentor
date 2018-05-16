<?php
App::uses('AppModel', 'Model');
/**
 * UserExpenseClaim Model
 * 
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class UserExpenseClaim extends AppModel {
    
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
		'description' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please describe what this expense claim is for',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'money' => array(
				'rule' => array('money'),
				'message' => 'Please enter the amount of the claim',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date_claimed' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_claimed'),                            
                        )
		),
		'reimbursed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'UserExpenseClaim', 'reimbursed', 'date_reimbursed', 
                                'Please enter the date that the expenses were reimbursed'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,                            
                        )
		),
		'date_reimbursed' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_reimbursed'),                            
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'UserExpenseClaim', 'reimbursed', 'date_reimbursed', 
                                'Please check the "Reimbursed" box if the expenses were reimbursed. Or leave the "Date Reimbursed" field empty if not.'),
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
