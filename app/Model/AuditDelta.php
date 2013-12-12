<?php
App::uses('AppModel', 'Model');
/**
 * AuditDelta Model
 *
 * @property Audit $Audit
 */
class AuditDelta extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Audit' => array(
			'className' => 'Audit',
			'foreignKey' => 'audit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
