<?php
App::uses('AppModel', 'Model');
/**
 * UserStatus Model
 *
 */
class UserStatus extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	
	public $order = array(
			'roletype_id' => 'ASC',
			'number' => 'ASC'
			);
	
	public $actsAs = array(
			'AuditLog.Auditable' => array(
					'ignore' => array( 'created' )
			)
	);
	

public $belongsTo = array(
		'Roletype' => array(
				'className' => 'Roletype',
				'foreignKey' => 'roletype_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		)
		);

}