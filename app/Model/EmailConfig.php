<?php
App::uses('AppModel', 'Model');
/**
 * EmailConfig Model
 *
 * @property Tenant $Tenant
 */
class EmailConfig extends AppModel {

    public $actsAs = array(
            'AuditLog.Auditable' => array(
               'ignore' => array( 'modified', 'created' )
            )
        );

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tenant_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from_email' => array(
			'email' => array(
				'rule' => array('email'),
                                'message' => 'Please enter a valid e-mail address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sender_email' => array(
			'email' => array(
				'rule' => array('email'),
                                'message' => 'Please enter a valid e-mail address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'host_port' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'SendTestEmailTo' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid e-mail address',
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
		'Tenant' => array(
			'className' => 'Tenant',
			'foreignKey' => 'tenant_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
