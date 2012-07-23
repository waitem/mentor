<?php
App::uses('AppController', 'Controller');
/**
 * UserExpenseClaims Controller
 * 
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 *
 * @property UserExpenseClaim $UserExpenseClaim
 */
class UserExpenseClaimsController extends AppController {

        var $helpers = array('Form', 'Html', 'Text', 'Custom', 'Number');
        
        public $paginate = array(
            // other keys here.
            'maxLimit' => 12,
            'order' => array(
               'UserExpenseClaim.date_claimed' => 'asc'
            )
        );

        public function isAuthorized($user) { 
            
            $myUserId = $this->Session->read('Auth.User.id');
            $myRoletypeName = $this->Session->read('Roletype.name');
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            
            // Anyone - except mentees - can list or add a expense for themselves
            if (in_array($this->action, array('index', 'add'))) {
                if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator', 'Mentor'))) {
                    return true;
                }
            } elseif (in_array($this->action, array( 'edit', 'view'))) {
                $id = $this->request->params['pass'][0];
                // Note that this data is subsequently used by the edit action
                //$this->request->data = $this->UserExpenseClaim->read(null, $id);
                $data = $this->UserExpenseClaim->read(null, $id);
                // Important people can edit any expense claim in their tenant
                if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))
                    // Make sure it belongs to my tenant
                    && $data['User']['tenant_id'] == $myTenantId ) {
                        return true;                    
                } else {
                    // Others (mentors) can only edit if it has not already been reimbursed
                    // Make sure that it belongs to me!!
                    //if ($this->request->data['UserExpenseClaim']['user_id'] == $myUserId) {
                    if ( $data['UserExpenseClaim']['user_id'] == $myUserId ) {
                            if ($this->action == 'edit' &&
                                    $data['UserExpenseClaim']['reimbursed'] ) {
                                return false;
                            }
                        // it does
                        return true;
                    }
                }
            } elseif (in_array($this->action, array( 'delete'))) {
                $id = $this->request->params['pass'][0];
                // Read the record in now to validate the owner
                // Note that this data is subsequently used by the edit action
                //$this->request->data = $this->UserExpenseClaim->read(null, $id);
                $data = $this->UserExpenseClaim->read(null, $id);
                // Make sure that it belongs to me!!
                //if ($this->request->data['UserExpenseClaim']['user_id'] == $myUserId) {                
                if ($data['UserExpenseClaim']['user_id'] == $myUserId) {
                    // it does
                    return true;
                }
            }
          
            // Otherwise take the default authorisation
            return parent::isAuthorized($user);
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {

            $myUserId = $this->Session->read('Auth.User.id');
            $myRoletypeName = $this->Session->read('Roletype.name');
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            
            // if a mentor, then only list claims
            // belonging to that user
            if ($myRoletypeName == 'Mentor') {
                $conditions = array( 
                        'UserExpenseClaim.user_id' => $myUserId,
                        'User.tenant_id' => $myTenantId
                    );
                $showAll = false;
                $this->set( 'userId', $myUserId);
            } else {
                $conditions = array('User.tenant_id' => $myTenantId);
                $showAll = true;
                $this->set( 'userId', null);
            }
                
            $this->UserExpenseClaim->recursive = 0;
            $this->set('userExpenseClaims', $this->paginate( $conditions));
            $this->set('showAll', $showAll);
            
            //echo $user['Roletype']['name'] . ' - ' ;
            $title = 'Expense Claims';
            if (! $showAll ) {
                $title = 'My ' . $title;

            }
            $this->set('title_for_layout', $title);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->UserExpenseClaim->id = $id;
		if (!$this->UserExpenseClaim->exists()) {
			throw new NotFoundException(__('Invalid user expense claim'));
		}
		$this->set('userExpenseClaim', $this->UserExpenseClaim->read(null, $id));
                
                $title = ucfirst($this->action) . ' Expense Claim';
                
                $this->set('title_for_layout', $title);
	}

        function modify($action, $id = null) {

                if ($this->request->is('post') || 
                        ($this->action == 'edit' && $this->request->is('put'))) {
                    if ($this->action == 'add' )  {
                        $this->UserExpenseClaim->create();                            
                    }
                    if ($this->UserExpenseClaim->save($this->request->data)) {
				$this->Session->setFlash(__('The expense claim has been saved'),
                                            'default',
                                            array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The expense claim could not be saved. Please check below.'));

			}
                } elseif ($action == 'edit') {
                    // We come here the first time we edit a record, before trying to save it
                    // No need to do this, as it is now done during the isAuthorized check ...
                    $this->request->data = $this->UserExpenseClaim->read(null, $id);
		}
                
                $myUserId = $this->Session->read('Auth.User.id');

                // When adding a new expense claim ...
                if ($action == 'add') {

                    // force the user_id to be me 
                    $this->request->data['UserExpenseClaim']['user_id'] = $myUserId;
                    // and the date to today
                    $this->request->data['UserExpenseClaim']['date_claimed'] = date('Y-m-d');
                }
                
                $title = ucfirst($this->action) . ' an Expense Claim';
                if ($this->action == 'edit' && $myUserId != $this->request->data['User']['id']) {
                    $title = $title . ' from ' . $this->request->data['User']['name'];
                }
                
                $this->set('title_for_layout', $title);
                //Debugger::dump($this->request);
                $this->render('modify');
 
        }
 
/**
 * add method
 *
 * @return void
 */
        public function add() {
            $this->modify($this->action);
        }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
        public function edit($id = null) {
            	$this->UserExpenseClaim->id = $id;
		if (!$this->UserExpenseClaim->exists()) {
			throw new NotFoundException(__('Invalid expense claim'));
		}
                $this->modify($this->action, $id);
                
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
		$this->UserExpenseClaim->id = $id;
		if (!$this->UserExpenseClaim->exists()) {
			throw new NotFoundException(__('Invalid user expense claim'));
		}
		if ($this->UserExpenseClaim->delete()) {
			$this->Session->setFlash(__('User expense claim deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User expense claim was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
