<?php
App::uses('AppModel', 'Model');
/**
 * UserAddress Model
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
class UserAddress extends AppModel {

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
		'postcode' => array(
			'numeric' => array(
                                'rule' => array('custom', '/^[0-9]{4}$/'),
                                'message' => 'Please enter a valid postcode',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'recover_account_postcode' => array(
			'numeric' => array(
				'rule' => array('custom', '/^[0-9]{4}$/'),
				'message' => 'Please enter a valid postcode',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
