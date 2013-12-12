<?php
App::uses('AppModel', 'Model');
/**
 * Invoice Model
 *
 * @property User $User
*/
class Invoice extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'invoice_number';
	
	public $order = 'invoice_number ASC';

	public $actsAs = array(
			'AuditLog.Auditable' => array(
					'ignore' => array( 'created' )
			)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	*/
	public $validate = array(
			'invoice_number' => array(
					'four_digit' => array(
							'rule' => '/^[0-9]{4}$/',
							'message' => 'Please enter a 4-digit invoice number'
					),
					'unique' => array(
							'rule' => 'isUnique',
							'message' => 'This invoice number has already been used, please enter a new invoice number'
					)
			),
			'date_invoiced' => array(
					'date' => array(
							'rule' => array('date'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'total_amount' => array(
					'money' => array(
							'rule' => array('money'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
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
