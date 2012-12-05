<?php
App::uses('AppController', 'Controller');
/**
 * MenteeSurveys Controller
 * 
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @property MenteeSurvey $MenteeSurvey
 */
class MenteeSurveysController extends AppController {

/**
 * Helpers
 *
 * @var array
 */

        var $helpers = array('Form', 'Html', 'Text', 'Custom');
        
        public $paginate = array(
            // other keys here.
            'maxLimit' => 12,
            'order' => array(
               'MenteeSurvey.date_sent' => 'asc'
            )
        );

        public function isAuthorized($user) { 
            
            $myUserId = $this->Session->read('Auth.User.id');
            $myRoletypeName = $this->Session->read('Roletype.name');
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            
            // Anyone - except mentees - can list or add a expense for themselves
            if (in_array($this->action, array('index', 'add'))) {
                if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {
                    return true;
                }
            } elseif (in_array($this->action, array( 'edit', 'delete'))) {
                $id = $this->request->params['pass'][0];
                // Note that this data is subsequently used by the edit action
                //$this->request->data = $this->MenteeSurvey->read(null, $id);
                $data = $this->MenteeSurvey->read(null, $id);
                // Important people can edit any mentee survey in their tenant
                if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {
                    // Make sure it belongs to my tenant
                    if ($data['User']['tenant_id'] == $myTenantId) {
                        return true;
                    }
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
                $myTenantId = $this->Session->read('Auth.User.tenant_id');
		$this->MenteeSurvey->recursive = 0;
		$this->set('menteeSurveys', $this->paginate(
                        array(
                            'User.tenant_id' => $myTenantId,
                        )));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->MenteeSurvey->id = $id;
		if (!$this->MenteeSurvey->exists()) {
			throw new NotFoundException(__('Invalid mentee survey'));
		}
		$this->set('menteeSurvey', $this->MenteeSurvey->read(null, $id));
	}

        public function modify($action, $id = null) {
            
            $myTenantId = $this->Session->read('Auth.User.tenant_id');
            
                if ($this->request->is('post') || 
                        ($this->action == 'edit' && $this->request->is('put'))) {
                    if ($this->action == 'add' )  {
                        $this->MenteeSurvey->create();                            
                    }
                    if ($this->MenteeSurvey->save($this->request->data)) {
				$this->Session->setFlash(__('The mentee survey has been saved'),
                                            'default',
                                            array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mentee survey could not be saved. Please check below.'));

			}
                } elseif ($action == 'edit') {
                    // We come here the first time we edit a record, before trying to save it
                    // No need to do this, as it is now done during the isAuthorized check ...
                    $this->request->data = $this->MenteeSurvey->read(null, $id);
		}

                $users = $this->MenteeSurvey->User->find('list',
                                array(
                                    'conditions' => array(
                                        'User.tenant_id' => $myTenantId,
                                        'User.roletype_id' => 5,    
                                    ),
                                    'order' => array(
                                        'User.first_name' => 'asc'
                                    )
                                )
                            );
		$this->set(compact('users'));
                
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
            	$this->MenteeSurvey->id = $id;
		if (!$this->MenteeSurvey->exists()) {
			throw new NotFoundException(__('Invalid mentee survey'));
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
		$this->MenteeSurvey->id = $id;
		if (!$this->MenteeSurvey->exists()) {
			throw new NotFoundException(__('Invalid mentee survey'));
		}
		if ($this->MenteeSurvey->delete()) {
			$this->Session->setFlash(__('Mentee survey deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Mentee survey was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
