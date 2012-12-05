<?php
App::uses('AppController', 'Controller');
/**
 * UserAwayDates Controller
 * 
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 *
 * @property UserAwayDate $UserAwayDate
 */
class UserAwayDatesController extends AppController {

        var $helpers = array('Form', 'Html', 'Text', 'Custom');
     
        public $paginate = array(
            // other keys here.
            'maxLimit' => 12,
            'order' => array(
               'UserAwayDate.first_day_away' => 'asc'
            )
        );

        public function isAuthorized($user) { 
            
            $myUserId = $this->Session->read('Auth.User.id');
            
            // Anyone can list or add a date away for themselves
            if (in_array($this->action, array('add', 'index'))) {
                return true;
            } elseif (in_array($this->action, array('edit', 'delete'))) {
                $id = $this->request->params['pass'][0];
                // Read the record in now to validate the owner
                // Note that this data is subsequently used by the edit action
                //$this->request->data = $this->UserAwayDate->read(null, $id);
                $data = $this->UserAwayDate->read(null, $id);
                // Make sure that it belongs to me!!
                //if ($this->request->data['UserAwayDate']['user_id'] == $myUserId) {                
                if ($data['UserAwayDate']['user_id'] == $myUserId) {
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
		$this->UserAwayDate->recursive = 0;
                
                $myUserId = $this->Session->read('Auth.User.id');
                $conditions = array('UserAwayDate.user_id' => $myUserId);
                
		$this->set('userAwayDates', $this->paginate('UserAwayDate', $conditions));
                $this->set('title_for_layout', 'Dates I\'m away or unavailable');
	}

/**
 * add method
 *
 * @return void
 */
	function modify($action, $id = null) {

                if ($this->request->is('post') || 
                        ($this->action == 'edit' && $this->request->is('put'))) {
                    if ($this->action == 'add' )  {
                        $this->UserAwayDate->create();                            
                    }
                    if ($this->UserAwayDate->save($this->request->data)) {
                            $this->Session->setFlash(__('The date has been saved'),
                                            'default',
                                            array('class' => 'success'));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The date could not be saved. Please check below.'));
                            //Debugger::dump($this->request->data);
                    }
                } elseif ($action == 'edit') {
                    // No need to do this, as it is now done during the isAuthorized check ...
                    $this->request->data = $this->UserAwayDate->read(null, $id);                        
		}
                
                //$this->set('action', $action);
                $myUserId = $this->Session->read('Auth.User.id');
                // force the user_id to be me 
                $this->request->data['UserAwayDate']['user_id'] = $myUserId;
                //Debugger::dump($this->request);
                $this->set('title_for_layout', ucfirst($this->action) . ' ' . __('a date that I\'m away') );
                $this->render('modify');
	}

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
		$this->UserAwayDate->id = $id;
		if (!$this->UserAwayDate->exists()) {
			throw new NotFoundException(__('Invalid user away date'));
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
		$this->UserAwayDate->id = $id;
		if (!$this->UserAwayDate->exists()) {
			throw new NotFoundException(__('Invalid user away date'));
		}
		if ($this->UserAwayDate->delete()) {
			$this->Session->setFlash(__('Date deleted'),
                                            'default',
                                            array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Date was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
