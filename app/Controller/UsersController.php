<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 * 
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @property User $User
 */
class UsersController extends AppController {
    
     var $helpers = array('Form', 'Html', 'Text', 'Time', 'Custom');
     
        public $paginate = array(
            // other keys here.
            'maxLimit' => 12,
            'order' => array(
               'User.roletype_id' => 'desc'
            )
        );
        
        public function isAuthorized($user) { 
            
            $myUserId = $this->Session->read('Auth.User.id');
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
            $myRoletypeName = $this->Session->read('Roletype.name');
            $myParentId = $this->Session->read('Auth.User.parent_id');
            $myParentUserParentId = $this->Session->read('ParentUser.parent_id');
            

          if (in_array($this->action, array( 'login', 'logout', 'dashboard'))) {
              return true;
              // Mentees are not allowed to view the profiles
          } elseif ( $this->action == 'index') {
              if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) ) ) {
                return true;
              } else {
                $this->Auth->authError = "Sorry, but you are not allowed to do that";
                return false;
              }
              // Only allow Superadmins, Admins and Coordinators to add users
          } elseif ( in_array($this->action, array( 'add_mentor', 'add_mentee', 'list_mentees', 'list_mentors' ))) {
              if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    return true;
              } else {
                  $this->Auth->authError = "Sorry - Only Coordinators and Admins can do that";
                  return false;
              }
          } elseif ( in_array($this->action, array( 'add_coordinator', 'list_coordinators' ))) {
              if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin') ) ) {
                    return true;
              } else {
                  $this->Auth->authError = "Sorry - Only Admins can do that";
                  return false;
              }
          } elseif ( in_array($this->action, array( 'add_admin', 'list_admins' ))) {
              if ( $myRoletypeName == 'Superadmin' ) {
                    return true;
              } else {
                  $this->Auth->authError = "Sorry - Only Superadmins can do that";
                  return false;
              }
          } elseif ( in_array($this->action, array( 'delete' ))) {
              if ( $myRoletypeName == 'Superadmin' ) {
                    return true;
              } else {
                  $this->Auth->authError = "Sorry - Only Superadmins can delete users";
                  return false;
              }
          } elseif (in_array($this->action, array('view_profile', 'view', 'edit', 'modify', 'change_password'))) {
            $userId = $this->request->params['pass'][0];   
            return $this->User->canBeAccessedBy($userId, $this->action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $myParentUserParentId ); 
          }
          
          // Otherwise take the default authorisation
          return parent::isAuthorized($user);
        }

    /**
 * login method
 *
 * @return void
 */
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
                            
                            // Check that we are running on a tested version of Cake
                            $good_cake_versions = Configure::read('Mentor.good_cake_versions');
                            if (! in_array(Configure::version(), $good_cake_versions)) {
                                // Oh dear, we don't have a good version of cake
                                $this->Session->setFlash('Sorry, but this system has some incorrect or untested software installed. Please contact the system administrator.');
                                $this->Auth->logoutRedirect = array('controller'=>'pages', 'action'=>'bad_cake_version');
                                $this->redirect($this->Auth->logout());
                            }
                            $user_id = $this->Auth->user('id');
                            // Get some information about the user about the currently logged in user
                            $logged_in_user_details = $this->User->getUserDetails($user_id);
                            // if the user is not the Superuser, and their account is not active 
                            // then log them out again
                            if ($logged_in_user_details['Roletype']['name'] != 'Superadmin' &&
                                $logged_in_user_details['User']['active'] != 1) {
                                $this->Session->setFlash('Sorry, your account is not (yet) activated, please contact the coordinator');
                                $this->redirect($this->Auth->logout());
                            }
                                
                            // Not necessary to store User information in the Session
                            // as this is automatically done by Auth, so e.g. User.Id can be 
                            // accessed as $this->Session->read('Auth.User.id')
                            // $this->Session->write('User.id', $id);
                            // $this->Session->write('User.name', $logged_in_user_details['User']['name']);
                            $this->Session->write('Roletype.id', $logged_in_user_details['Roletype']['id']);
                            $this->Session->write('Roletype.name', $logged_in_user_details['Roletype']['name']);
                            $this->Session->write('Tenant.name', $logged_in_user_details['Tenant']['name']);
                            // Get the users' grandparent (i.e. mentee's coordinator
                            $parentDetails = $this->User->getUserDetails($this->Session->read('Auth.User.parent_id'));
                            $this->Session->write('ParentUser.parent_id', $parentDetails['User']['parent_id']);
                            
                            // and setup the redirect to view this user                                                       
                            $this->Auth->loginRedirect = array('controller'=>'users', 'action'=> 'view', $logged_in_user_details['User']['id']);
                            //$this->Auth->loginRedirect = array('controller'=>'users', 'action'=> 'dashboard');
                            
                           $this->redirect($this->Auth->redirect());
                        } else {
                            $this->Session->setFlash('Hmmm, something was wrong with your username or password');
                        }
		}
                $this->set('title_for_layout', 'Login Screen');
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
                /**
                 * Take the user to whichever screen was defined
                 * as logoutRedirect element of the Auth component 
                 * (currently defined in the AppController)
                 */
                 // No reason to keep the session data after the user has logged out
                $this->Session->destroy();
		$this->redirect($this->Auth->logout());
            
	}
        
        function list_users($action = null, $roletype, $sortOrder = array('User.roletype_id' => 'desc')) {
            $this->User->recursive = 0;

            $myRoletypeName = $this->Session->read('Roletype.name');
            $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            $myUserId = $this->Session->read('Auth.User.id');
            $myParentId = $this->Session->read('Auth.User.parent_id');
            
            $this->paginate['order'] = $sortOrder;

            /* 
            $users =    User::getChildPaginate($this->action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName) ;
            Configure::write('debug', 2);
            Debugger::dump($users);
            Configure::write('debug', 0);
             * 
             */
            // If active:false passed as a parameter to the controller, then
            // set active to 0
            // e.g. mentor/users/list_mentees/active:false
            //
            if (array_key_exists('active', $this->params['named']) && $this->params['named']['active'] == 'false') {
                $active = 0;
            } else {
                $active = 1;
            }
            $this->set('users', 
                    $this->paginate('User', 
                        User::getChildPaginate($this->action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $active)
                            // + array( 'order' => $sortOrder)
                            )
                    );
            // Default title for view ...
            $title = $roletype . 's';
            if (! $active) {
                $title = 'Inactive ' . $roletype . 's';
            }
            // Default view to render ...
            $view = 'list_users';
            // Default title
            $this->set('roletype', $roletype);
            if ($this->action == 'index') {
                $title = 'Profiles';
                $view = 'list_profiles';
            } elseif (array_key_exists('email', $this->params['named']) && $this->params['named']['email'] == 'true') {
                $title = 'Email ' . $roletype . 's';
                $view = 'email_users';   
            }
            $this->set('title_for_layout', $title);
            $this->render($view);
        }
/**
 * index method
 *
 * @return void
 */
	public function index() {
	        
            $this->list_users($this->action, "Profile" );

	}

                
        public function dashboard() {
            $myUserId = $this->Session->read('Auth.User.id');
            $this->redirect(array('action' => 'view', $myUserId));
            //$this->list_users($this->action, 'Dashboard' );

	}
        
        public function list_mentees() {

            $this->list_users($this->action, 'Mentee', array( 'MenteeExtraInfo.date_joined' => 'asc'));

	}
        
        public function list_mentors() {

            $this->list_users($this->action, 'Mentor', array( 'MentorExtraInfo.date_joined' => 'asc'));           

	}
        
        public function list_coordinators() {

            $this->list_users($this->action, 'Coordinator', array( 'User.last_name' => 'asc') );

	}
        
        public function list_admins() {

            $this->list_users($this->action, 'Admin', array( 'User.last_name' => 'asc'));

	}
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
        function view_user($id = null, $action = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
                
                $this->User->data = $this->User->read(null, $id);
                $myUserId = $this->Session->read('Auth.User.id');
                //Debugger::dump($this->User->data);
                // Only show user_away_dates in full view
                if ($action == 'view') {
                    $userAwayDates = $this->User->UserAwayDate->getDetails($id);
                    $this->set('userAwayDates', $userAwayDates);
                    
                    //Define access to parent
                    /* */

                    $myRoletypeName = $this->Session->read('Roletype.name');
                    $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
                    $myTenantId = $this->Session->read('Auth.User.tenant_id');
                    $myParentId = $this->Session->read('Auth.User.parent_id');
                    $myParentUserParentId = $this->Session->read('ParentUser.parent_id');
                    // returns one of 'none', 'view' or 'view_profile' ...
                    $parentView = $this->User->getView( $this->User->data['User']['parent_id'], 
                            $this->User->data['User']['roletype_id'],
                            $this->User->data['User']['tenant_id'],
                            $myUserId, $myRoletypeName, $myRoletypeId, $myTenantId, $myParentId, $myParentUserParentId );
                    $this->set('parentView', $parentView);
                    $canViewChildren = $this->User->canViewChildren( 
                            $id , 
                            $this->User->data['User']['roletype_id'],
                            $this->User->data['Roletype']['name'],
                            $myUserId, $myRoletypeName, $myRoletypeId );
                    $this->set('canViewChildren', $canViewChildren);
                    //Debugger::dump($canViewChildren);
                }
                
		$this->set('user', $this->User->data);
                
                if ($myUserId == $this->User->data['User']['id']) {
                    $title = 'My ';
                } else {
                    $title = $this->User->data['User']['name'] . '\'s ';                    
                }
                if ($action == 'view') {
                    $title = $title . 'details';
                } else {
                    $title = $title . 'profile';
                }
                if ($myUserId != $this->User->data['User']['id']) {
                        $title = $title . ' (' . $this->User->data['Roletype']['name'] . ')';
                }
                $this->set('title_for_layout', $title);
                $this->render( $action);
	}
        
	public function view($id = null) {
                $this->view_user($id, $this->action);
		
	}

        public function view_profile($id = null) {
                $this->view_user($id, $this->action);
		
	}

/**
 * add method
 *
 * @return void
 */
        public function add_admin() {
            
            $this->modify(null, ADMIN);
            
        }
        
        public function add_coordinator() {
            
            $this->modify(null, COORDINATOR);
        }
        
	public function add_mentor() {

            $this->modify(null, MENTOR);
        }
        
     	public function add_mentee() {

            $this->modify(null, MENTEE);
            
        }

        /**
 * modify method
 *
 * @param string $id
 * @return void
 */
	function modify($id = null, $newRoletypeId = null) {

                $myRoletypeName = $this->Session->read('Roletype.name');
                $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
                $myTenantId = $this->Session->read('Auth.User.tenant_id');
                $myUserId = $this->Session->read('Auth.User.id');
                $myAction = $this->action;

                if (in_array($this->action, array('add_admin', 'add_coordinator', 'add_mentor', 'add_mentee')) )  {
                    $myAction = 'add';
                }
                
                if ($this->request->is('post') || 
                        ($this->action == 'edit' && $this->request->is('put'))) {
                    if ($myAction == 'add' )  {
                        $this->request->data['User']['tenant_id'] = $myTenantId;
                        $this->User->create();                            
                    }
                    if ($id == $this->Session->read('Auth.User.id')) {
                        $flashMessage = 'Your details';
                    } else  {
                        $flashMessage = $this->request->data['User']['first_name'] . __('\'s details');
                    }
                    $result = $this->User->saveAssociated($this->request->data);                    
			if ($result) {
				$this->Session->setFlash( $flashMessage . ' have been updated',
                                            'default',
                                            array('class' => 'success'));
                                // if the user was a superadmin, update the tenant name in the session
                                // just in case the user has switched tenant
                                if ($myAction == 'edit' && $this->request->data['User']['roletype_id'] == 1) {
                                    $userdata = $this->User->read(null, $id);
                                    $this->Session->write('Tenant.name', $userdata['Tenant']['name']);
                                    $this->Session->write('Auth.User.tenant_id', $userdata['User']['tenant_id'] );
                                }
                                if ($myAction == 'add' ) {
                                    $this->redirect(array('action' => 'view', $this->User->getLastInsertID()));
                                } else {
                                    $this->redirect(array('action' => 'view', $id));
                                }
                                // $this->Auth->loginRedirect = array('controller'=>'users', 'action'=> 'view', $logged_in_user_details['User']['id']);
			} else {
				$this->Session->setFlash( $flashMessage . ' could not be updated. Please check for errors in each of the tabs');
                                // Set the newRoletypeId based on the existing one
                                $newRoletypeId = $this->request->data['User']['roletype_id'];
			}
		} elseif ($this->action == 'edit') {
			$this->request->data = $this->User->read(null, $id);
                        // Set the newRoletypeId based on the existing one
                        $newRoletypeId = $this->request->data['User']['roletype_id'];
		}

                // set the roletype_id just in case we're adding a new user
                 if (! array_key_exists( 'User', $this->request->data) ||
                         ! array_key_exists( 'roletype_id', $this->request->data['User']) )  {
                         $this->request->data['User']['roletype_id'] = $newRoletypeId;
                 }
                 if (! array_key_exists( 'User', $this->request->data) ||
                         ! array_key_exists( 'id', $this->request->data['User'] ) )  {
                         $this->request->data['User']['id'] = null;
                 }
                // Set up tenants picklist                
                if ($myRoletypeName == 'Superadmin') {                   
                    $tenants = $this->User->Tenant->find('list');
                } else {
                    $tenants = $this->User->Tenant->find('list',
                            array(
                                    'conditions' => array(                                        
                                        'Tenant.id' => $myTenantId,
                                    )
                                )
                            );
                }
                
                $roletypes = $this->User->Roletype->find('list',
                    array(
                            'conditions' => array(                                        
                                'Roletype.id' => $newRoletypeId
                            )
                        )
                    );
                
                $newRoletypeName = $roletypes[$newRoletypeId];
                $this->set('newRoletypeName', $newRoletypeName);
                
               $parentUsers = $this->User->ParentUser->find(
                    'list',
                    array(
                        'conditions' => array(
                            'ParentUser.active' => true,
                            'ParentUser.roletype_id =' => $newRoletypeId - 1,
                            'ParentUser.tenant_id' => $myTenantId,
                        ),
                        'order' => array(
                            'ParentUser.first_name' => 'asc'
                        )
                     )   
                    );

                // Allow a mentee to be unassigned
                if ($newRoletypeId == MENTEE ) {
                    // Put a user "Unassigned" at the beginning of the list
                    $parentUsers = array( 0 => 'Unassigned' ) + $parentUsers;
                }
                
                $roletype = $this->User->Roletype->find(
                    'first',
                    array(
                        'conditions' => array(
                            'Roletype.id =' => $newRoletypeId - 1,
                         )
                    )
                );
                $parentRoletypeName = $roletype['Roletype']['name'];
                $this->set('parentRoletypeName', $parentRoletypeName);
                
                //  Debugger::dump($this->request->data);
                $this->set('user', $this->request->data);
                                
		$this->set(compact('tenants', 'roletypes', 'parentUsers'));
                
                if ($myAction == 'add') {
                    $title = 'Add ' . ucfirst( $newRoletypeName);
                } else {
                    $title = 'Edit ';
                    if ($myUserId == $this->User->data['User']['id']) {
                        $title = $title . 'my details';
                    } else {
                        $title = $title . $this->request->data['User']['name'] . '\'s details (' . $newRoletypeName . ')';                    
                    }
                    
                }
                $this->set('title_for_layout', $title);
                $this->render('modify');
	}

        
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
                $this->modify($id);

	}

            public function change_password($id = null) {

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The password has been updated'),
                                            'default',
                                            array('class' => 'success'));
                                $this->redirect(array('action' => 'view', $id));				
			} else {
				$this->Session->setFlash(__('The password could not be updated. Please check below.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}

                $this->set('user', $this->request->data);

                $myUserId = $this->Session->read('Auth.User.id');                
                $title = __('Change') . ' ';
                if ($myUserId == $this->User->data['User']['id']) {
                    $title = $title . 'my';
                } else {
                    $title = $title . $this->User->data['User']['name'] . '\'s';
                }
                $title = $title . ' password';
                $this->set('title_for_layout', $title);
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'dashboard'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'dashboard'));
	}
}
