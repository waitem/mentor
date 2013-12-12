<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
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
class UsersController extends AppController {

	public $helpers = array('Form', 'Html', 'Text', 'Time', 'Custom');
	public $paginate = array(
			// other keys here.
			'limit' => 12,
			'order' => array(
					'User.roletype_id' => 'desc'
			)
	);

	public function isAuthorized($user) {

		// Everyone must be allowed to login!
		if (in_array($this->action, array('login', 'recover_account'))) {
			return true;
		}

		$myUserId = $this->Session->read('Auth.User.id');
		// If we are not logged in, then we are not authorised to do anything else
		if ($myUserId == null) {
			return false;
		}

		$myTenantId = $this->Session->read('Auth.User.tenant_id');
		$myRoletypeId = $this->Session->read('Auth.User.roletype_id');
		$myRoletypeName = $this->Session->read('Roletype.name');
		$myParentId = $this->Session->read('Auth.User.parent_id');
		$mySecondMentorId = $this->Session->read('Auth.User.second_mentor_id');
		$myParentUserParentId = $this->Session->read('ParentUser.parent_id');

		if (in_array($this->action, array('logout', 'dashboard'))) {
			return true;
			// Mentees are not allowed to view the profiles
		} elseif ($this->action == 'index') {
			if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator', 'Mentor'))) {
				return true;
			} else {
				$this->Auth->authError = "Sorry, but you are not allowed to do that";
				return false;
			}
			// Only allow Superadmins, Admins and Coordinators to add users
		} elseif (in_array($this->action, array('add_mentor', 'add_mentee', 'list_mentees',
				'list_mentors', 'list_accounts', 'mentors_table', 'mentees_table', 'mentees_csv'))) {
				if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {
					return true;
				} else {
					$this->Auth->authError = "Sorry - Only Coordinators and Admins can do that";
					return false;
				}
		} elseif (in_array($this->action, array('add_coordinator', 'list_coordinators'))) {
			if (in_array($myRoletypeName, array('Superadmin', 'Admin'))) {
				return true;
			} else {
				$this->Auth->authError = "Sorry - Only Admins can do that";
				return false;
			}
		} elseif (in_array($this->action, array('add_admin', 'list_admins'))) {
			if ($myRoletypeName == 'Superadmin') {
				return true;
			} else {
				$this->Auth->authError = "Sorry - Only Superadmins can do that";
				return false;
			}
		} elseif (in_array($this->action, array('delete'))) {
			if ($myRoletypeName == 'Superadmin') {
				return true;
			} else {
				$this->Auth->authError = "Sorry - Only Superadmins can delete users";
				return false;
			}
			// Only allow the user (and superadmin) to change their own password!!
		} elseif (in_array($this->action, array('change_password'))) {
			if ($myRoletypeName == 'Superadmin' || $myUserId == $this->request->params['pass'][0]) {
				return true;
			} else {
				$this->Auth->authError = "Sorry - you are not allowed to do that";
				return false;
			}
			// forced password change - no action buttons shown
		} elseif (in_array($this->action, array('password_change'))) {
			if ($myUserId == $this->request->params['pass'][0]) {
				return true;
			} else {
				$this->Auth->authError = "Sorry - you are not allowed to do that";
				return false;
			}
		} elseif (in_array($this->action, array('view_profile', 'view', 'edit', 'modify', 'reset_password'))) {
			$userId = $this->request->params['pass'][0];
			return $this->User->canBeAccessedBy($userId, $this->action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $myParentUserParentId, $mySecondMentorId);
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

				$user_id = $this->Auth->user('id');

				// record the last_login time
				$this->User->id = $user_id;
				$this->User->saveField('last_login', time());

				// Check that we are running on a tested version of Cake
				$good_cake_versions = Configure::read('Mentor.good_cake_versions');
				if (!in_array(Configure::version(), $good_cake_versions)) {
					// Oh dear, we don't have a good version of cake
					$this->Session->setFlash('Sorry, but this system has some incorrect or untested software installed. Please contact the system administrator.');
					$this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'bad_cake_version');
					$redirect = $this->Auth->logout();
					return $this->redirect($redirect);
				}
				// FIXME: Check that we are running on a tested version of the database schema

				// Get some information about the user about the currently logged in user
				$logged_in_user_details = $this->User->getUserDetails($user_id);
				// if the user is not the Superuser, and their account is not active
				// then log them out again
				//$this->log(print_r($logged_in_user_details, TRUE), LOG_DEBUG);
				if ($logged_in_user_details['Roletype']['name'] != 'Superadmin' &&
				$logged_in_user_details['User']['active'] != 1) {
					$this->Session->setFlash('Sorry, your account is not (yet) activated, please contact the coordinator');
					$this->Auth->logout();
					return $this->redirect('/');
				}

				// Not necessary to store User information in the Session
				// as this is automatically done by Auth, so e.g. User.Id can be
				// accessed as $this->Session->read('Auth.User.id')
				// $this->Session->write('User.id', $id);
				// $this->Session->write('User.name', $logged_in_user_details['User']['name']);
				$this->Session->write('Roletype.id', $logged_in_user_details['Roletype']['id']);
				$this->Session->write('Roletype.name', $logged_in_user_details['Roletype']['name']);
				$this->Session->write('Tenant.name', $logged_in_user_details['Tenant']['name']);
				// If the user doesn't have a timezone set, default to Australia/Brisbane
				$user_timezone = $logged_in_user_details['User']['timezone'];
				if (!strlen($user_timezone)) {
					$this->Session->write('Auth.User.timezone', 'Australia/Brisbane');
				} else {
					$this->Session->write('Auth.User.timezone', $timezone);
				}
				// Get the users' grandparent (i.e. mentee's coordinator
				$parent_id = $this->Session->read('Auth.User.parent_id');
				// If the parent id is set, then save it in the session
				if ($parent_id != NULL && $parent_id > 0) {
					$parentDetails = $this->User->getUserDetails($parent_id);
					$this->Session->write('ParentUser.parent_id', $parentDetails['User']['parent_id']);
					// Otherwise just save "0" as the parent_id (e.g. if we are superadmin
				} else {
					$this->Session->write('ParentUser.parent_id', 0);
				}
		
				// Max password age - in seconds - before forced to change again
				$max_password_age = 365 * 24 * 60 * 60;
				// If the user's password has been set
				if (array_key_exists('last_password_change', $logged_in_user_details['User']) &&
				$logged_in_user_details['User']['last_password_change'] > time() - $max_password_age) {
					// and setup the redirect to view this user
					$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
					// otherwise force them to enter a new password
				} else {
					if ($logged_in_user_details['User']['last_password_change'] > 0  &&
					$logged_in_user_details['User']['last_password_change'] <= time() - $max_password_age) {
						$this->Session->setFlash('It\'s time to change your password again');
					}
					$this->Auth->loginRedirect = array(
							'controller' => 'users', 'action' => 'password_change',
							$logged_in_user_details['User']['id']
					);
				}

				return $this->redirect($this->Auth->loginRedirect);
			} else {
				$this->Session->setFlash('Hmmm, something was wrong with your username or password');
			}
		}
		//Debugger::dump($this->Session->read());
		// If the session contains a redirect, then we can assume that the session expired
		// so change the flash message accordingly
		if ($this->Session->check('Auth.redirect')) {
				/* 
				 * A new "feature" with cakephp 2.3.4 was that the last redirect seems
				 * to be carried over into the next session, which meant that when logging in
				 * we were redirected to the logged_out page - not too helpful!
				 * So we now check when logging in and remove any redirect to the logged_out page
				 * which doesn't really make any sense to redirect to after logging in!
				 */
				
				if (in_array($this->Session->read('Auth.redirect'), array('/pages/logged_out', '/users/logout'))) {
					$this->Session->delete('Auth.redirect');
				} else {
					$this->Session->write('Message.auth.message', 'For security reasons, your session was automatically ended after ' .
						Configure::read('Session.timeout') .
						' minutes of inactivity. Please login again to continue.');
				}
		}
		$this->set('title_for_layout', 'Login');
	}

	public function recover_account() {

		$step = 'step_1';
		// clear any session to avoid confusing things
		$this->Session->destroy();
		if ($this->request->is('post')) {
			// FIXME: see if they are logged in - if so, redirect to users home page with appropriate message
			// Now validate the data entered
			if (array_key_exists('recover_account_email', $this->request->data['User'])) {
				// Set the data to the model
				// (see: http://book.cakephp.org/2.0/en/models/data-validation/validating-data-from-the-controller.html)
				$this->User->set($this->request->data);
				// See if the postcode has been entered too ...
				if (array_key_exists('UserAddress', $this->request->data) &&
				array_key_exists('recover_account_postcode', $this->request->data['UserAddress'])) {
					// validate both fields (have to use saveAll to do this)
					if ($this->User->saveAll($this->request->data, array('validate' => 'only'))) {
						// we passed the field validation, now lookup to see
						// if a user exists with this email and postcode
						$userData = $this->User->find('first', array(
								'conditions' => array(
										'User.email =' => $this->request->data['User']['recover_account_email'],
										'UserAddress.postcode =' => $this->request->data['UserAddress']['recover_account_postcode'],
								)
						)
						);
						if (sizeof($userData) > 0) {
							// if it's valid, then reset their password
							// but first check that their account is set to active
							if (!$userData['User']['active']) {
								$this->Session->setFlash(__('Sorry, your password could not be reset - maybe your account hasn\'t been activated yet?'));
							} else {
								$email_config = $this->get_email_config($userData['User']['tenant_id']);
								if (!$email_config) {
									$this->Session->setFlash(__('Sorry, the email settings have not yet been configured on this system, so we are unable to send you a new password'));
								} else {
									if ($this->send_new_password($userData['User']['id'], '', $email_config)) {
										$this->Session->setFlash(__('Your password has been reset - you should receive an e-mail shortly'));
									} else {
										$this->Session->setFlash(__('Your password could not be reset.'));
									}
								}
							}
							return $this->redirect(array('action' => 'login'));
						} else {
							// put up a flash message and go back to step_1 (default)
							$this->Session->setFlash('Unfortunately your email and postcode don\'t match - please try again. If that fails, please contact the administrator');
							$this->request->data = null;
						}
					} else {
						// invalid - try again
						$step = 'step_2';
					}
				} else {
					// only the email has been entered so far
					if ($this->User->validates(array('fieldList' => array('recover_account_email')))) {
						// if it's valid, then move on to step 2
						$step = 'step_2';
					} else {
						// invalid
					}
				}
			}
		}
		// Debugger::dump($this->request->data);
		$this->render('recover_account_' . $step);
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

		// record the last_login time
		$this->User->id = $this->Auth->user('id');;
		$this->User->saveField('last_logout', time());

		// No reason to keep the session data after the user has logged out
		$this->Session->delete('Roletype');
		$this->Session->delete('Tenant');
		$this->Session->delete('ParentUser');
		$this->Auth->logout();
		return $this->redirect(array('controller' => 'pages', 'action' => 'logged_out'));
	}

	/*
	 * Download mentee data as spreadsheet
	*/
	function mentees_csv() {
		 
		$myTenantId = $this->Session->read('Auth.User.tenant_id');
		 
		//create a file
		date_default_timezone_set(SessionComponent::read('Auth.User.timezone'));
		$filename = date("Y-m-d")."_mentees.csv";
		$csv_file = fopen('php://output', 'w');
		 
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$this->User->recursive = 0;
		$results = $this->User->find('all', array(
				'conditions' => User::getChildPaginate($this->action, null, null, $myTenantId),
				'order' => array( 'UserStatus.number' => 'asc')
		));
		
		$columns = array(
				array(
					'label' => 'Status',
					'model' => 'UserStatus',
					'field' => 'name'
					),
				array(
						'label' => 'Mentee',
						'model' => 'User',
						'field' => 'name',
						'link' => array('controller' => 'users', 
										'action' => 'view', 
										'pass' => array(
												'model' => 'User',
												'field' => 'id')
										)
				),
				array(
						'label' => 'Company',
						'model' => 'MenteeExtraInfo',
						'field' => 'company_name'
				),
				array(
						'label' => 'Contacted',
						'model' => 'MenteeExtraInfo',
						'field' => 'date_statement_of_purpose_sent'
				),
				array(
						'label' => 'Joined (1st Invoice Paid)',
						'model' => 'MenteeExtraInfo',
						'field' => 'date_joined'
				),
				array(
						'label' => 'Invoice No.',
						'model' => 'MenteeExtraInfo',
						'field' => 'invoice_number'
				),
				array(
						'label' => 'Invoice Sent',
						'model' => 'MenteeExtraInfo',
						'field' => 'date_invoiced'
				),
				array(
						'label' => 'Invoice Paid',
						'model' => 'MenteeExtraInfo',
						'field' => 'date_payment_received'
				),
				array(
						'label' => 'Waiver form signed',
						'model' => 'MenteeExtraInfo',
						'field' => 'date_waiver_form_signed'
				),
				array(
						'label' => 'Mentor',
						'model' => 'ParentUser',
						'field' => 'name',
						'link' => array('controller' => 'users',
								'action' => 'view',
								'pass' => array(
										'model' => 'ParentUser',
										'field' => 'id')
						)
				),					
				array(
						'label' => '2nd Mentor',
						'model' => 'SecondMentor',
						'field' => 'name',
						'link' => array('controller' => 'users',
								'action' => 'view',
								'pass' => array(
										'model' => 'SecondMentor',
										'field' => 'id')
						)
				),
				array(
						'label' => 'Phone',
						'model' => 'User',
						'field' => 'phone_number'
				),
				array(
						'label' => 'Email',
						'model' => 'User',
						'field' => 'email'
				)
		);
		 
		// The column headings of your .csv file
		$header_row = array();
		foreach ($columns as $column) {
			// add each label onto the array
			$header_row[] = $column['label'];
		};
		//debug($header_row);
		fputcsv($csv_file,$header_row,',','"');
		 
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		foreach($results as $result)
		{
			$row = array();
			
			foreach ($columns as $column) {
				// Check that the desired data exists in the result
				// if not put a "?" as the value
				if (array_key_exists($column['model'], $result) &&
						array_key_exists($column['field'], $result[$column['model']])
				) {
					if (array_key_exists('link', $column)) {
						$row[] = '=HYPERLINK("' . 
						Router::url(array(
										'controller' => $column['link']['controller'],
										'action' => $column['link']['action'],
										$result[$column['link']['pass']['model']][$column['link']['pass']['field']]
									),
									// full URL please ...
									true) . 
						'","' . 
						 $result[$column['model']][$column['field']] . '")' 
						;
					} elseif ($column['field'] == 'email') {
						$row[] = '=HYPERLINK("mailto:' . $result[$column['model']][$column['field']] .
										'","' .
										$result[$column['model']][$column['field']] . '")'
												;
					} else {
						$row[] = $result[$column['model']][$column['field']];
					}
				} else {
					$row[] = '?';
				}
			};
			 
			fputcsv($csv_file,$row,',','"');
			//break;
		}
		 
		fclose($csv_file);
		$this->autoRender = false;
	}

	function list_users($roletype, $sortOrder = array('User.roletype_id' => 'desc'), $view = 'list_users') {
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
				
		if (array_key_exists('paid', $this->params['named']) && $this->params['named']['paid'] == 'false') {
			$paid = 0;
		} else {
			$paid = 1;
		}

		// Retrieve the normal conditions for this action
		if ($view != 'list_users') {
			$conditions = $this->User->getChildPaginate($view, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $active, $paid);			
		} else {
			$conditions = $this->User->getChildPaginate($this->action, $myUserId, $myParentId, $myTenantId, $myRoletypeId, $myRoletypeName, $active, $paid);
		}

		
		if (($view == 'mentees_table') || in_array($this->action, array('mentees_table', 'mentors_table'))) {

			$additional_conditions = false;
			// If they only want to see inactive mentees
			if (($view == 'mentees_table') || $this->action == 'mentees_table') {
				$threshold = 50;
			} else {
				// for mentors
				$threshold = 50;
			}
			
			if ( array_key_exists('inactive', $this->params['named']) && $this->params['named']['inactive'] == 'true') {
				// inactive mentees or mentors
				$additional_conditions = array( 'UserStatus.number >' =>  $threshold );
			} else {
				// active mentees or mentors
				$additional_conditions = array( 'UserStatus.number <=' =>  $threshold );
			}

			// allow 100 at a time to be shown (same as default maxLimit)
			$this->paginate['limit'] = 100;
			
			// if any have been defined append any appropriate conditions
			if ($additional_conditions) {
				$conditions[] = $additional_conditions;
			}
		}
				
		// If we want to produce a list of e-mail addresses, 
		// or we are the coordinator in mobile view, then don't use pagination
		if (($myRoletypeId == COORDINATOR && (strpos($this->viewPath, 'mobile') !== false)) || 
			(array_key_exists('email', $this->params['named']) && $this->params['named']['email'] == 'true')) 
			{
			$this->set('users', $this->User->find('all', 
												array(	'conditions' => $conditions,
														'order' => $sortOrder
			 									) 
											)
					);
		} else {
			$this->set('users', $this->paginate('User', $conditions ) );
		}
		// Default title for view ...
		$title = $roletype . 's';
		if (!$active) {
			$title = 'Inactive ' . $roletype . 's';
		}
		// Default view to render ...
		
		// Default title
		$this->set('roletype', $roletype);
		if ($this->action == 'index') {
			$title = 'Profiles';
			$view = 'list_profiles';
		} elseif (array_key_exists('email', $this->params['named']) && $this->params['named']['email'] == 'true') {
			$title = 'Email ' . $roletype . 's';
			$view = 'email_users';
		} elseif ($this->action == 'list_accounts') {
			$title = 'Mentee Accounts ';
			if ($paid) {
				$title = $title . 'Paid';
			} else {
				$title = $title . 'Unpaid';
			}
			$view = 'list_accounts';
		} elseif ($view == 'mentees_table') {
				$title = $roletype . 's';
		} elseif (in_array($this->action, array('mentees_table', 'mentors_table'))) {
			$title = $roletype . 's';
			$view = $this->action;
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

		$this->list_users("Profile");
	}

	public function dashboard() {
		$myRoletypeId = $this->Session->read('Auth.User.roletype_id');
		if ($myRoletypeId == COORDINATOR) {
			// use the mentees screen as the dashboard for coordinators
			$this->mentees_table();
		} else {
			$myUserId = $this->Session->read('Auth.User.id');
			$this->view_user($myUserId, $this->action);
		}
	}

	public function list_mentees() {

		$this->list_users('Mentee', array('MenteeExtraInfo.date_joined' => 'asc'));
	}

	public function list_accounts() {

		$this->list_users('Mentee', array('MenteeExtraInfo.date_joined' => 'asc'));
	}

	public function mentees_table() {

		$this->list_users('Mentee', array('UserStatus.number' => 'asc', 'User.name' => 'asc'), 'mentees_table');
	}

	public function list_mentors() {

		$this->list_users('Mentor', array('User.name' => 'asc'));
	}

	public function mentors_table() {
	
		$this->list_users('Mentor', array('UserStatus.number' => 'asc', 'User.name' => 'asc' ));
	}
	
	public function list_coordinators() {

		$this->list_users('Coordinator', array('User.last_name' => 'asc'));
	}

	public function list_admins() {

		$this->list_users('Admin', array('User.last_name' => 'asc'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	function view_user($id = null, $action = null) {

		$myUserId = $this->Session->read('Auth.User.id');
		// If we are not logged in, then do nothing
		if ($myUserId == null) {
			return;
		}

		// This extra check is needed because during testing, although
		// isAuthorized returns false, the action is carried out nevertheless
		// If we are not authorised to view the requested user, then
		// revert to viewing ourselves!
		if (!$this->isAuthorized($myUserId)) {
			$id = $myUserId;
		}

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}

		$this->User->data = $this->User->read(null, $id);
		//Debugger::dump($this->User->data);

		// Only show user_away_dates in full view
		if (in_array($action, array('view', 'dashboard'))) {
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
			$parentView = $this->User->getView($this->User->data['User']['parent_id'], $this->User->data['User']['roletype_id'], $this->User->data['User']['tenant_id'], $myUserId, $myRoletypeName, $myRoletypeId, $myTenantId, $myParentId, $myParentUserParentId,
					$this->User->data['User']['second_mentor_id']);
			$this->set('parentView', $parentView);
			$canViewChildren = $this->User->canViewChildren(
					$id, $this->User->data['User']['roletype_id'], $this->User->data['Roletype']['name'], $myUserId, $myRoletypeName, $myRoletypeId);
			$this->set('canViewChildren', $canViewChildren);
			//Debugger::dump($canViewChildren);
		}

		// if this is a mentor, get the prime mentor's name for each of the mentees that they are second mentor for
		if ($this->User->data['User']['roletype_id'] == MENTOR) {
			$index = 0;
			foreach ($this->User->data['SecondMentorFor'] as $second_mentor_for) {
				if ($second_mentor_for['parent_id'] > 0) {
					$mentor = $this->User->find('first',
							array(
									'conditions' => array(
											'User.id' => $second_mentor_for['parent_id']
									)
							)
					);
					$this->User->data['SecondMentorFor'][$index]['mentor_name'] = $mentor['User']['name'];
				}

				$index++;
			}
			$index = 0;
			foreach ($this->User->data['ChildUser'] as $mentor_for) {
				if ($mentor_for['second_mentor_id'] > 0) {
					$mentor = $this->User->find('first',
							array(
									'conditions' => array(
											'User.id' => $mentor_for['second_mentor_id']
									)
							)
					);
					$this->User->data['ChildUser'][$index]['second_mentor_name'] = $mentor['User']['name'];
				}
				$index++;
			}
		}
		//Debugger::dump($this->User->data);

		$this->set('user', $this->User->data);

		// If we are at the mobile version of the dashboard, then call it "Home"
		if ($this->action == 'dashboard' && (strpos($this->viewPath, 'mobile') !== false)) {
			$title = 'Home';
		} elseif ($myUserId == $this->User->data['User']['id']) {
			$title = 'My details';
		} else {
			$title = $this->User->data['User']['name'];
		}
		$this->set('title_for_layout', $title);

		if ($this->action == 'dashboard') {
			$this->render('view');
		} else {
			$this->render($action);
		}
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

		if (in_array($this->action, array('add_admin', 'add_coordinator', 'add_mentor', 'add_mentee'))) {
			$myAction = 'add';
		}

		if ($this->request->is('post') ||
		($this->action == 'edit' && $this->request->is('put'))) {
			if ($myAction == 'add') {
				$this->request->data['User']['tenant_id'] = $myTenantId;
				$this->User->create();
			}
			if ($id == $this->Session->read('Auth.User.id')) {
				$flashMessage = 'Your details';
			} else {
				$flashMessage = $this->request->data['User']['first_name'] . __('\'s details');
			}
			// Get the details of this userStatus - to find out whether the userStatus is "active" or not
			$userStatus = $this->User->UserStatus->read(null, $this->request->data['User']['user_status_id']);
			// Set the 'active' value to the same as for the userStatus
			$this->request->data['User']['active'] = $userStatus['UserStatus']['active'];
			$result = $this->User->saveAssociated($this->request->data);
			if ($result) {
				$this->Session->setFlash($flashMessage . ' have been updated', 'default', array('class' => 'success'));
				// if the user was a superadmin, update the tenant name in the session
				// just in case the user has switched tenant
				if ($myAction == 'edit' && $this->request->data['User']['id'] == $myUserId) {
					$userdata = $this->User->read(null, $id);
					// Just in case we have updated our name details ...
					$this->Session->write('Auth.User.name', $userdata['User']['name']);
					if ($this->request->data['User']['roletype_id'] == SUPERADMIN) {
						$this->Session->write('Tenant.name', $userdata['Tenant']['name']);
						$this->Session->write('Auth.User.tenant_id', $userdata['User']['tenant_id']);
					}
				}
				if ($this->request->data['User']['roletype_id'] == MENTOR && $myRoletypeId <= COORDINATOR) {
					return $this->redirect(array('action' => 'mentors_table'));
				} elseif ($this->request->data['User']['roletype_id'] == MENTEE && $myRoletypeId <= COORDINATOR) {
						return $this->redirect(array('action' => 'mentees_table'));
				} else {
					if ($myAction == 'add') {
						return $this->redirect(array('action' => 'view', $this->User->getLastInsertID()));
					} else {
						return $this->redirect(array('action' => 'view', $id));
					}
				}
				// $this->Auth->loginRedirect = array('controller'=>'users', 'action'=> 'view', $logged_in_user_details['User']['id']);
			} else {
				$this->Session->setFlash($flashMessage . ' could not be updated. Please check for errors in each of the tabs');
				// Set the newRoletypeId based on the existing one
				$newRoletypeId = $this->request->data['User']['roletype_id'];
			}
		} elseif ($this->action == 'edit') {
			$this->request->data = $this->User->read(null, $id);
			// Set the newRoletypeId based on the existing one
			$newRoletypeId = $this->request->data['User']['roletype_id'];
		}

		// set the roletype_id just in case we're adding a new user
		if (!array_key_exists('User', $this->request->data) ||
		!array_key_exists('roletype_id', $this->request->data['User'])) {
			$this->request->data['User']['roletype_id'] = $newRoletypeId;
		}
		if (!array_key_exists('User', $this->request->data) ||
		!array_key_exists('id', $this->request->data['User'])) {
			$this->request->data['User']['id'] = null;
		}
		// Set up tenants picklist
		if ($myRoletypeName == 'Superadmin') {
			$tenants = $this->User->Tenant->find('list');
		} else {
			$tenants = $this->User->Tenant->find('list', array(
					'conditions' => array(
							'Tenant.id' => $myTenantId,
					)
			)
			);
		}

		$user_statuses = $this->User->UserStatus->find('list', array(
				'conditions' => array(
						'UserStatus.roletype_id' => $newRoletypeId
				)
		)
		);
		$this->set('userStatuses', $user_statuses);

		$roletypes = $this->User->Roletype->find('list', array(
				'conditions' => array(
						'Roletype.id' => $newRoletypeId
				)
		)
		);
		$newRoletypeName = $roletypes[$newRoletypeId];
		$this->set('newRoletypeName', $newRoletypeName);

		$parentUsers = $this->User->ParentUser->find(
				'list', array(
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
		if ($newRoletypeId == MENTEE) {
			// Put a user "Unassigned" at the beginning of the list
			$parentUsers = array(0 => 'Unassigned') + $parentUsers;
			$secondMentors = array(0 => 'None') + $parentUsers;
			$this->set('secondMentors', $secondMentors);
		}

		$roletype = $this->User->Roletype->find(
				'first', array(
						'conditions' => array(
								'Roletype.id =' => $newRoletypeId - 1,
						)
				)
		);

		//if (array_key_exists('name', $roletype['Roletype'])) {
		if ($roletype) {
			$parentRoletypeName = $roletype['Roletype']['name'];
			$this->set('parentRoletypeName', $parentRoletypeName);
		}

		//Debugger::dump($this->request->data);
		$this->set('user', $this->request->data);

		$this->set(compact('tenants', 'roletypes', 'parentUsers'));

		if ($myAction == 'add') {
			$title = 'Add ' . ucfirst($newRoletypeName);
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

	function whose($myUserId = null, $requestUserId = null, $requestUserName = null, $mystring = 'Your') {
		if ($myUserId == $requestUserId) {
			return $mystring;
		} else {
			return $requestUserName . '\'s';
		}
	}

	public function change_password($id = null, $forced_change = false) {

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$myUserId = $this->Session->read('Auth.User.id');

		if ($this->request->is('post') || $this->request->is('put')) {
			// set the last_password_change date and time
			// FIXME: Note that the modified and created timestamps are still in LOCAL time!!
			$this->request->data['User']['last_password_change'] = time();
			if ($this->User->save($this->request->data)) {
				$who = $this->whose($myUserId, $this->request->data['User']['id'], $this->request->data['User']['first_name']);
				$this->Session->setFlash(__($who . ' password has been updated'), 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The password could not be updated. Please check the error messages below.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}

		$this->set('user', $this->request->data);

		$this->set('forced_change', $forced_change);

		$title = __('Change ') .
		$this->whose($myUserId, $this->request->data['User']['id'], $this->request->data['User']['first_name'], 'my') .
		' password';
		$this->set('title_for_layout', $title);
		$this->render('change_password');
	}

	public function password_change($id = null) {
		// call change_password but indicate forced_change with true
		$this->change_password($id, true);
	}

	/*
	 * Function generate_password
	* @return string containing a 10-character password
	*/

	function generate_password() {
		$new_password = substr(str_shuffle('ABCDEFGHJKLMNPQRTUVWXYZ2346789'), 0, 7);
		$funny_char = substr(str_shuffle('!@#$'), 0, 1);
		return str_shuffle($new_password . $funny_char);
	}

	function get_email_config($tenant_id = null) {

		$this->loadModel('EmailConfig');
		$email_config = $this->EmailConfig->find('first', array(
				'conditions' => array(
						'EmailConfig.tenant_id' => $tenant_id
				)
		));
		//Debugger::dump($email_config);
		// If no e-mail config exists, or if it is not verified, then give up
		if (!array_key_exists('EmailConfig', $email_config)) {
			return false;
		} elseif (!$email_config['EmailConfig']['tested']) {
			return false;
		}
		return $email_config;
	}

	function send_new_password($id = null, $instigator = '', $email_config = null) {

		// First we generate a new password
		// Then we try to e-mail it to the user
		// If that works ok then we actually change it
		$new_password = $this->generate_password();

		// Get the user data (again)
		// We re-read the user data in to avoid e.g. the email field being overwritten
		// with wrong data in order to send the password data somewhere else
		$this->request->data = $this->User->read(null, $id);

		$this->email = new CakeEmail(
				array(
						'transport' => 'Smtp',
						// when we're using gmail, gmail sets the sender to the account used
						// so the sender fields may not be used
						'sender' => array($email_config['EmailConfig']['sender_email'] => $email_config['EmailConfig']['sender_name']),
						'from' => array($email_config['EmailConfig']['from_email'] => $email_config['EmailConfig']['from_name']),
						// To use the "real" from email and name we need to have email configs per user
						// and then send the email using the user's config (overriding the tenant config)
						// 'from' => array($from_email => $from_name),
						// 'replyTo' => array($from_email => $from_name),
						'host' => $email_config['EmailConfig']['host_name'],
				'port' => $email_config['EmailConfig']['host_port'],
				'username' => $email_config['EmailConfig']['host_username'],
				'password' => $email_config['EmailConfig']['host_password'],
				'timeout' => 30,
				'client' => null,
				'log' => false,
		)
		);

		if (Configure::read('debug') > 0) {
			$recipient = 'mark.a.waite@gmail.com';
		} else {
			$recipient = $this->request->data['User']['email'];
		}

		$this->email->to($recipient);
		$this->email->subject('Your Mentoring Application password has been reset');
		try {
			$this->email->send('Dear ' .
					$this->request->data['User']['first_name'] . ',' .
					"\n\nYour password for the Mentoring Application has just been reset" .
					" to a temporary one.\n\n" .
					"Your temporary password is: " . $new_password . "  \n\n" .
					"Please use this password when you log in next time to " .
					Router::url('/', true) . "\n\n" .
					"Note that after logging in, you will have to enter a new password.\n\n" .
					"Best regards\n\n" .
					$instigator . "\n" .
					"Business Mentoring" . ' ' . $this->request->data['Tenant']['name']
			);
		} catch (Exception $exc) {
			//echo $exc->getTraceAsString();
			throw new InternalErrorException('Unable to send e-mail - please check e-mail configuration');
		}

		// if no password previously set, then set it to the new one
		// This is then overwritten again by the User model beforeSave() method
		if ( is_null($this->request->data['User']['password']) ) {
			$this->request->data['User']['password'] = $new_password;
		}
		$this->request->data['User']['new_password'] = $new_password;
		$this->request->data['User']['password_confirmation'] = $new_password;
		$this->request->data['User']['last_password_change'] = null;
		$this->request->data['User']['last_password_reset'] = time();
		
		return $this->User->save($this->request->data);
	}

	public function reset_password($id = null) {

		$myUserId = $this->Session->read('Auth.User.id');
		// If we are not logged in, then do nothing
		if ($myUserId == null) {
			return;
		}

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}

		$email_config = $this->get_email_config($this->Session->read('Auth.User.tenant_id'));
		if (!$email_config) {
			$this->Session->setFlash(__('ERROR: Unable to send emails - the email settings have not yet been successfully configured'));
			return $this->redirect(array('action' => 'view', $id));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			$who = $this->request->data['User']['first_name'] . '\'s';
			if ($this->send_new_password($id, $this->Session->read('Auth.User.name'), $email_config)) {
				$this->Session->setFlash(__($who . ' password has been reset'), 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__($who . ' password could not be reset.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}

		$this->set('user', $this->request->data);
		$recipient = $this->request->data['User']['email'];
		if (Configure::read('debug') > 0) {
			$recipient = 'mark.a.waite@gmail.com' . ' (debug mode: instead of ' . $recipient . ')';
		}
		$this->set('recipient', $recipient);
		$who = $this->User->data['User']['first_name'] . '\'s';
		$title = __('Reset ') . $who . ' password';
		$this->set('title_for_layout', $title);
		$this->set('who', $who);
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
			return $this->redirect(array('action' => 'dashboard'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		return $this->redirect(array('action' => 'dashboard'));
	}

}
