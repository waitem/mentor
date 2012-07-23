<?php
App::uses('AppController', 'Controller');
/**
 * Roletypes Controller
 * 
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 *
 * @property Roletype $Roletype
 */
class RoletypesController extends AppController {
    
       public function isAuthorized($user) { 
            
              if ( $this->Session->read('Roletype.name') == 'Superadmin' ) {
                    return true;
              }
              
              $this->Auth->authError = "Sorry - Only Superadmins can do anything with roletypes";
              return false;
              
        }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Roletype->recursive = 0;
		$this->set('roletypes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Roletype->id = $id;
		if (!$this->Roletype->exists()) {
			throw new NotFoundException(__('Invalid roletype'));
		}
		$this->set('roletype', $this->Roletype->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Roletype->create();
			if ($this->Roletype->save($this->request->data)) {
				$this->Session->setFlash(__('The roletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The roletype could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Roletype->id = $id;
		if (!$this->Roletype->exists()) {
			throw new NotFoundException(__('Invalid roletype'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Roletype->save($this->request->data)) {
				$this->Session->setFlash(__('The roletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The roletype could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Roletype->read(null, $id);
		}
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
		$this->Roletype->id = $id;
		if (!$this->Roletype->exists()) {
			throw new NotFoundException(__('Invalid roletype'));
		}
		if ($this->Roletype->delete()) {
			$this->Session->setFlash(__('Roletype deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Roletype was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
