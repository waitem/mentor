<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * Copyright (c) 2012-2013 Mark Waite
 *
 * Author(s): See AUTHORS.txt
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property Profile $Profile
 * @property Tenant $Tenant
 * @property Roletype $Roletype
 * @property User $ParentUser
 * @property User $ChildUser
 */
class User extends AppModel {
      //var $actsAs = array('Containable');

  public $actsAs = array(
            'AuditLog.Auditable' => array(
               'ignore' => array( 'created' )
            )
        );
  
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        /*
        public $virtualFields = array(
            'name' => 'CONCAT(first_name, " ", last_name)'
        );
         *
         */

        /*
         *  we need to defien the virtualField in the constructor
         * because this model is also referred to as ParentUser and ChildUser
         */
        public function __construct($id = false, $table = null, $ds = null) {
            parent::__construct($id, $table, $ds);
            $this->virtualFields['name'] = sprintf('CONCAT(%s.first_name, " ", %s.last_name)', $this->alias, $this->alias);
        }
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
                'first_name' => array(
			'notempty' => array(
                                'rule' => array('notempty'),
				'message' => 'Please enter a first name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'last_name' => array(
			'notempty' => array(
                                'rule' => array('notempty'),
				'message' => 'Please enter a surname',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
                        'email' => array(
                                'rule' => array('email'),
                                'message' => 'Please enter a valid e-mail address',
				'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'unique' => array(
                                'rule' => array('isUnique'),
                                'message' => 'Sorry, this e-mail address has already been used',
                        )
		),
                'recover_account_email' => array(
                        'email' => array(
                                'rule' => array('email'),
                                'message' => 'Please enter a valid e-mail address',
				'allowEmpty' => false,
				//'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your password',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'new_password' => array(
			'minlength' => array(
                                'rule' => array('minlength', 6),
                                'message' => 'Please enter a password of at least 6 characters',
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'Match passwords' => array(
                                'rule' => 'matchPasswords',
                                'message' => 'The passwords do not match'
                        )
		),
                'password_confirmation' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please re-enter the same password',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'second_mentor_id' => array(
                    'must_have_parent_id' => array(
                        'rule' => 'mustHaveParentId',
                        'message' => 'You cannot set a second mentor if the primary mentor is unassigned',
                        'allowEmpty' => true,
                    ),
                    'not_same_as_parent_id' => array(
                        'rule' => 'notSameAsParentId',
                        'message' => 'It doesn\'t make sense to have the same second mentor as the primary one?!',
                        'allowEmpty' => true,
                    )
                )
	);

        /**
         *
         * @param type $data
         * Contains the form data for that field only
         * @return type boolean
         *
         */
        public function matchPasswords($data) {
            /**
             * Note that we can only access other form data fields
             * through $this->data (as is done in the controllers)
             */
            if ($data['new_password'] == $this->data['User']['password_confirmation']) {
                return true;
            }
            /**
             * If we get here, then the password fields do not match, so
             * we must also invalidate the password_confirmation field
             * so that it too shows an error message
             */
            $this->invalidate('password_confirmation', 'The passwords do not match' );
            return false;
        }
        
        public function mustHaveParentId($field_value_array) {
            
            if ( $this->data['User']['second_mentor_id'] ) {
                /*
                 * If setting a second_mentor_id, then 
                 * ensure that the parent_id is also set
                 */
                if( $this->data['User']['parent_id'] ) {
                    // it is, all good
                    return true;
                } else {
                    // can't set a second_mentor without a parent_id
                    return false;
                }
            } else {
                // if the second mentor id is not set, we don't care
                // about the parent_id
                return true;
            }
            return false;
        }

        public function notSameAsParentId($field_value_array) {
            /*
             * If setting a second_mentor_id, then 
             * ensure that the parent_id is not the same
             */
            if ( $this->data['User']['second_mentor_id'] ) {
               if ($this->data['User']['parent_id'] != $this->data['User']['second_mentor_id']) {
                    return true;
               } else {
                   return false;
               }
            } else {
                // if the second mentor id is not set, we don't care
                // about the parent_id
                return true;
            }
            return false;
        }
        
        public function beforeSave($options = array()) {
            parent::beforeSave($options);
            // Check that the password field has been set, just in case
            if (isset($this->data['User']['new_password'])) {
                // Use the password method to hash the password
                $this->data['User']['password'] = AuthComponent::password($this->data['User']['new_password']);
            } elseif (isset($this->data['User']['edit_password'])) {
                // Use the password method to hash the password
                $this->data['User']['password'] = AuthComponent::password($this->data['User']['edit_password']);
            }
            return true;
        }

        public function getUserDetails($user_id) {

                // Now get some information about the user

                $user_details = User::find(
                                        'first',
                                        array(
                                            'conditions' => array(
                                                'User.id' => $user_id
                                            )
                                        )
                                     );
                return $user_details;
        }

        // Work out the view that we can use to show the user $userId
        public function getView($userId, $roletypeId, $tenantId, $myUserId, $myRoletypeName, $myRoletypeId, $myTenantId, $myParentId, $myParentUserParentId, 
                                $secondMentorId ) {

            // we can view ourselves
            if ($myUserId == $userId) {
                return 'view';
            // Superadmins can view anyone
            } elseif ($myRoletypeName == 'Superadmin') {
                return 'view';
            }

            // if we get this far but are not the same tenant, then we aren't allowed to see anything
            if ( $myTenantId != $tenantId ) {
                return 'none';
            }

            if ($myRoletypeName == 'Admin') {
                // we can view everyone below us, not including other admins
                if ( $myRoletypeId < $roletypeId ||
                        $myUserId == $userId) {
                    return( 'view');
                }
            } elseif ($myRoletypeName == 'Coordinator') {
                if ( $userId == $myParentId ) {
                    return 'view_profile';
                // we can view everyone below us, including other coordinators
                } elseif ( $myRoletypeId <= $roletypeId ) {
                    return( 'view');
                }
            } elseif ($myRoletypeName == 'Mentor') {
                if ( $userId == $myParentId ||
                        $myUserId == $secondMentorId) {
                    return 'view';
                    // Allow mentors to see other mentors' profiles
                } elseif ( $roletypeId == $myRoletypeId ) {
                    return 'view_profile';
                }

            } elseif ($myRoletypeName == 'Mentee') {
                if (in_array($userId, array( $myParentId, $myParentUserParentId, $secondMentorId))) {
                    return 'view';
                }

            }
            // default ...
            return 'none';
        }

        /* returns true if I can view the children
         *
         */
        public function canViewChildren( $userId, $roletypeId, $roletypeName, $myUserId, $myRoletypeName, $myRoletypeId ) {

            // If I'm a mentee or I'm looking at one, no children to see
           if ($myRoletypeName == 'Mentee' || $roletypeName == 'Mentee') {
               return false;
               // Everyone else can see their own children
           } elseif ($userId == $myUserId) {
                   return true;
               // These guys can see the children of their children downwards
           } elseif (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator')) &&
                           ( $myRoletypeId < $roletypeId )) {
               return true;
           }
           return false;
        }

        public function canBeAccessedBy($userId, $action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $myParentUserParentId, $mySecondMentorId ) {

            # If any parameters not set, assume that we are not correctly logged in
            if ($myUserId == null
                    or $myTenantId == null
                    or $myRoletypeId == null ) {
                return false;
            }

            $userDetails = User::getUserDetails( $userId);

            //
            // Do not let a user reset their own password
            // Also do not let a user's password be reset if they are not an active user
            if ($action == 'reset_password') {
                if ($myUserId == $userId || $userDetails['User']['active'] == false) {
                        return false;
                }
            }

            // Everyone can edit, view, change_password their own details
            if ($myUserId == $userId) {
                    return true;
            // Superadmins can edit, view, change_password anyone
            } elseif ($myRoletypeName == 'Superadmin') {
                return true;
            // Admins and Coordinators can edit, view, change_password  anyone at their level or below in their tenant
            } elseif ( in_array($myRoletypeName, array( 'Coordinator', 'Admin') )
                           && $myTenantId == $userDetails['User']['tenant_id'] ) {
                       // Coordinators can simple_view their admins
                       if ($action == 'view_profile' &&
                               $myRoletypeName == 'Coordinator'
                               ) {
                           if ( $myRoletypeId -1 <= $userDetails['Roletype']['id'] ) {
                               return true;
                           }
                       } elseif ( $myRoletypeId <= $userDetails['Roletype']['id'] ) {
                           return true;
                       }
            // Mentors can edit, view, change_password their mentees
            }  elseif ($myRoletypeName == 'Mentor' &&
                        $myTenantId == $userDetails['User']['tenant_id'] &&
                        $userDetails['User']['active'] == 1 &&
                        ($myUserId == $userDetails['User']['parent_id'] ||
                            $myUserId == $userDetails['User']['second_mentor_id'])
                        ) {
                        return true;
            // Mentors can have a restricted view of all of the mentors and coordinators
            } elseif (in_array($myRoletypeName, array( 'Mentor' ) ) ) {
                if ($action == 'view_profile' &&
                        $myTenantId == $userDetails['User']['tenant_id'] &&
                        $userDetails['User']['active'] == 1 &&
                        in_array( $userDetails['Roletype']['name'], array( 'Mentor', 'Coordinator' ) )
                    ) {
                    return true;
                } elseif ( $action == 'view') {
                    // A mentor can just view his parent (coordinator)
                    $ancestors = array( $myParentId );
                    // And the user must be the same Tenant and be active too
                    if ( $myTenantId == $userDetails['User']['tenant_id'] &&
                            $userDetails['User']['active'] == 1 &&
                            in_array( $userDetails['User']['id'], $ancestors )
                        ) {
                        return true;
                    }
                }
            } elseif (in_array($myRoletypeName, array( 'Mentee' ) ) ) {
                if ( in_array( $action, array('view', 'view_profile'))) {
                    // A mentee can view his parent (mentor) or parent's parent (coordinator)
                    $ancestors = array( $myParentId, $myParentUserParentId, $mySecondMentorId );
                    // And the user must be the same Tenant and be active too
                    if ( $myTenantId == $userDetails['User']['tenant_id'] &&
                            $userDetails['User']['active'] == 1 &&
                            in_array( $userDetails['User']['id'], $ancestors )
                        ) {
                        return true;
                    }
                }
            }

            return false;

        }

        public function getChildPaginate($action, $myUserId = null, $myParentId = null, $myTenantId, $myRoletypeId = null, $myRoletypeName = null, $active = null, $paid = null) {

        	if (in_array($action, array( 'mentees_table', 'mentees_csv'))) {
        		return array(
        				// Same tenant
        				'User.tenant_id' => $myTenantId,
        				// only mentees
        				'User.roletype_id' => 5,
        		);
        	} elseif (in_array($action, array( 'list_mentees' ))) {
               return array(
                   // Same tenant
                   'User.tenant_id' => $myTenantId,
                   // only mentees
                   'User.roletype_id' => 5,
                   'User.active' => $active,
               );
            } elseif ($action == 'list_accounts') {
                if ($paid) {
                   return array(
                       // Same tenant
                       'User.tenant_id' => $myTenantId,
                       // only mentees
                       'User.roletype_id' => 5,
                       'User.active' => $active,
                       'MenteeExtraInfo.invoiced' => 1,
                       'MenteeExtraInfo.payment_received' => 1,
                       'MenteeExtraInfo.coordinator_invoice_sent' => 1,
                       'MenteeExtraInfo.balance_paid' => 1,
                   );
                } else {
                   return array(
                       // Same tenant
                       'User.tenant_id' => $myTenantId,
                       // only mentees
                       'User.roletype_id' => 5,
                       'User.active' => $active,
                       'OR' => array(
                               'MenteeExtraInfo.invoiced' => 0,
                               'MenteeExtraInfo.payment_received' => 0,
                               'MenteeExtraInfo.coordinator_invoice_sent' => 0,
                               'MenteeExtraInfo.date_balance_paid' => 0,
                               'MenteeExtraInfo.invoiced' => null,
                               'MenteeExtraInfo.payment_received' => null,
                               'MenteeExtraInfo.coordinator_invoice_sent' => null,
                               'MenteeExtraInfo.date_balance_paid' => null,
                           )
                   );
                }
            } elseif ($action == 'list_mentors') {
               return array(
                   // Same tenant
                   'User.tenant_id' => $myTenantId,
                   // only mentees
                   'User.roletype_id' => 4,
                   'User.active' => $active,
               );
            } elseif (in_array($action, array( 'mentors_table', 'mentors_csv'))) {
               	return array(
               			// Same tenant
               			'User.tenant_id' => $myTenantId,
               			// only mentees
               			'User.roletype_id' => 4,
               	);
           } elseif ($action == 'list_coordinators') {
               return array(
                   // Same tenant
                   'User.tenant_id' => $myTenantId,
                   // only mentees
                   'User.roletype_id' => 3,
                   'User.active' => $active,
               );
           } elseif ($action == 'list_admins') {
               return array(
                   // Same tenant
                   'User.tenant_id' => $myTenantId,
                   // only mentees
                   'User.roletype_id' => 2,
                   'User.active' => $active,
               );
            }
            // Superadmins can list anyone
            if ($myRoletypeName == 'Superadmin') {
                   return null;
            // Admins and Coordinators can list anyone at their level or below in their tenant
            } elseif ( in_array($myRoletypeName, array( 'Coordinator', 'Admin') ) ) {
                   if ($action == 'index') {
                       return array(
                            'User.tenant_id' => $myTenantId,
                            // Include admins in the contact list
                            'User.roletype_id >=' => $myRoletypeId - 1,
                           // Only active users
                           'User.active' => $active,
                            );
                   } else {
                       return array(
                            'User.tenant_id' => $myTenantId,
                            'User.roletype_id >=' => $myRoletypeId,
                           // exclude themselves from the dashboard view
                           'User.id !=' => $myUserId,
                            );
                   }
            // Mentors can see the profiles of the other mentors
            }  elseif ($myRoletypeId == MENTOR) {
            	// listing profiles
                if ($action == 'index') {
                    return array(
                                    'User.tenant_id' => $myTenantId,
                                    'User.active' => 1,
                    				'User.roletype_id' => MENTOR
                            );
                // in the dashboard only show their mentees
                } else {
                    return array(
                                    'User.tenant_id' => $myTenantId,
                                    'User.active' => 1,
                                    'OR' => array(
                                        // my mentees
                                        'User.parent_id' => $myUserId,
                                        // my coordinator
                                        'User.id' => $myParentId
                                    )
                             );
                }
                // Mentees can view the mentors
            } elseif ($myRoletypeId == MENTEE ) {
                    return array(
                                    'User.tenant_id' => $myTenantId,
                                    'User.active' => 1,
                                    'OR'  => array(
                                        // we need to put each of these conditions in an array because
                                        // they use the same key
                                        array(
                                            // Mentor
                                            'User.id' => $myParentId
                                        ),
                                        array(
                                            // Coordinator
                                            'User.id' => $this->Session->read('ParentUser.parent_id')
                                        )
                                    )
                        );
            }

        }

        //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'UserAddress' => array(
			'className' => 'UserAddress',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'MentorExtraInfo' => array(
			'className' => 'MentorExtraInfo',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'MenteeExtraInfo' => array(
			'className' => 'MenteeExtraInfo',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

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
		),
		'Roletype' => array(
			'className' => 'Roletype',
			'foreignKey' => 'roletype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentUser' => array(
			'className' => 'User',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'SecondMentor' => array(
			'className' => 'User',
			'foreignKey' => 'second_mentor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserStatus' => array(
			'className' => 'UserStatus',
			'foreignKey' => 'user_status_id',
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
		'ChildUser' => array(
			'className' => 'User',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => array('ChildUser.active' => true),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SecondMentorFor' => array(
			'className' => 'User',
			'foreignKey' => 'second_mentor_id',
			'dependent' => false,
			'conditions' => array('SecondMentorFor.active' => true),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'UserAwayDate' => array(
			'className' => 'UserAwayDate',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'UserAwayDate.first_day_away ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Invoice' => array(
				'className' => 'Invoice',
				'foreignKey' => 'user_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => 'Invoice.date_invoiced DESC',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
		),
	);

}
