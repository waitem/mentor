<?php
App::uses('AppModel', 'Model');
/**
 * MenteeExtraInfo Model
 * 
 * Copyright (c) 2012-2014 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class MenteeExtraInfo extends AppModel {
    
    public $actsAs = array(
            'AuditLog.Auditable' => array(
               'ignore' => array( 'modified', 'created' )
            )
        );

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'mentee_extra_info';
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
        'where_did_they_hear_about_us' => array(
			'length' => array(
				'rule' => array('maxLength', 100),
                                'message' => 'Please enter a maximum of 100 characters in this field',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),            
		'date_joined' => array(
			'date' => array(
				'rule' => array('date'),
                                'message' => 'Please enter the date that the mentee joined',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'notInFuture' => array(
                'rule' => array( 'dateNotInFuture', 'date_joined'),                            
            )
		),
        'waiver_form_signed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'checkDate' => array(
                'rule' => array( 'checkDate', 'MenteeExtraInfo', 'waiver_form_signed', 'date_waiver_form_signed', 
                              'Please enter the date that the waiver form was signed'),
                 // If this isn't here, the checkbox becomes "required" for some reason ...
                 'allowEmpty' => true,
            ),
		),
		'date_waiver_form_signed' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'notInFuture' => array(
                'rule' => array( 'dateNotInFuture', 'date_waiver_form_signed'),                            
            ),
		),
		// this field is now being used for "Date contacted" ...
		'date_statement_of_purpose_sent' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'notInFuture' => array(
                'rule' => array( 'dateNotInFuture', 'date_statement_of_purpose_sent'),                            
            ),
		),
        'company_web_site' => array(
			'url' => array(
				'rule' => 'url',
                                'message' => 'Please enter a valid website address',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'invoiced' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'checkDate' => array(
                'rule' => array( 'checkDate', 'MenteeExtraInfo', 'invoiced', 'date_invoiced', 
                                'Please enter the date that the mentee invoice was sent'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                'allowEmpty' => true,                            
            ),
            'invoiceNumber' => array(
            	'rule' => array( 'invoiceNumberSet', 'MenteeExtraInfo', 'invoiced', 'invoice_number', 
                                'Please enter an invoice number'),
            ),
		),
		'invoice_number' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This invoice number has already been used',
				// If this isn't here, the invoice_number field becomes "required" ...
				'allowEmpty' => true,
			)
		),
		'date_invoiced' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_invoiced'),                            
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MenteeExtraInfo', 'invoiced', 'date_invoiced', 
                                'Please check the "Mentee invoice sent" box if the mentee has been invoiced. Or leave the "Date mentee invoice sent" field empty if not.'),
                        )
		),
		'payment_received' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'MenteeExtraInfo', 'payment_received', 'date_payment_received', 
                                'Please enter the date that the mentee invoice was paid'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,                            
                        ),
		),
		'date_payment_received' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_payment_received'),                            
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MenteeExtraInfo', 'payment_received', 'date_payment_received', 
                                'Please check the "Mentee invoice paid" box if the mentee invoice has been paid. Or leave the "Date mentee invoice paid" field empty if not.'),
                            ),
		),
		'coordinator_invoice_sent' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'MenteeExtraInfo', 'coordinator_invoice_sent', 'date_coordinator_invoice_sent', 
                                'Please enter the date that the coordinator invoice was sent to'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,                            
                        ),
		),
		'date_coordinator_invoice_sent' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_coordinator_invoice_sent'),                            
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MenteeExtraInfo', 'coordinator_invoice_sent', 'date_coordinator_invoice_sent', 
                                'Please check the "Coordinator invoice sent" box if the invoice has been sent. Or leave the "Date coordinator invoice sent" field empty if not.'),
                            ),
		),
		'balance_paid' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'checkDate' => array(
                            'rule' => array( 'checkDate', 'MenteeExtraInfo', 'balance_paid', 'date_balance_paid', 
                                'Please enter the date that the balance of the coordinator invoice was paid'),
                            // If this isn't here, the checkbox becomes "required" for some reason ...
                            'allowEmpty' => true,                            
                        ),
		),
		'date_balance_paid' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
                                'allowEmpty' => true,
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'notInFuture' => array(
                            'rule' => array( 'dateNotInFuture', 'date_balance_paid'),                            
                        ),
                        'notChecked' => array(
                            'rule' => array( 'notChecked', 'MenteeExtraInfo', 'balance_paid', 'date_balance_paid', 
                                'Please check the "Balance paid" box if the balance of the coordinator invoice has been paid. Or leave the "Date balance paid" field empty if not.'),
                            ),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
	
	public function invoiceNumberSet( $data, $model, $this_field, $other_field, $message ) {
		if ( $this->data[$model][$this_field] && strlen($this->data[$model][$other_field]) == 0) {
			$this->invalidate($other_field, $message );
		}
		return true;
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
		),
	);
}
