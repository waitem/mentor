<?php
App::uses('AppModel', 'Model');

/**
 * Tenant Model
 *
 * Copyright (c) 2012-2018 Mark Waite
 *
 * Author(s): See AUTHORS.txt
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class Tenant extends AppModel
{

    public $actsAs = array(
        'AuditLog.Auditable' => array(
            'ignore' => array('modified', 'created')
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
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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
                'allowEmpty' => false,
                //'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'tenant_id',
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
    public $hasOne = array(
        'EmailConfig' => array(
            'className' => 'EmailConfig',
            'foreignKey' => 'tenant_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
