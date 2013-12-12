<?php
App::uses('AppModel', 'Model');
/**
 * Audit Model
 *
 * @property user $user
 * @property AuditDelta $AuditDelta
 */
class Audit extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ChangedBy' => array(
			'className' => 'User',
			'foreignKey' => 'source_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserAffected' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)            
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AuditDelta' => array(
			'className' => 'AuditDelta',
			'foreignKey' => 'audit_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
