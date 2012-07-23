<?php
App::uses('AppController', 'Controller');
/**
 * Tenants Controller
 * 
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 *
 * @property Tenant $Tenant
 */
class TenantsController extends AppController {

       public function isAuthorized($user) { 
            
              if ( $this->Session->read('Roletype.name') == 'Superadmin' ) {
                    return true;
              } else {
                  $this->Auth->authError = "Sorry - Only Superadmins can do anything with tenants";
                  return false;
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
		$this->Tenant->recursive = 0;
		$this->set('tenants', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Tenant->id = $id;
		if (!$this->Tenant->exists()) {
			throw new NotFoundException(__('Invalid tenant'));
		}
		$this->set('tenant', $this->Tenant->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tenant->create();
			if ($this->Tenant->save($this->request->data)) {
				$this->Session->setFlash(__('The tenant has been saved'),
                                            'default',
                                            array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tenant could not be saved. Please, try again.'));
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

                
		$this->Tenant->id = $id;
		if (!$this->Tenant->exists()) {
			throw new NotFoundException(__('Invalid tenant'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tenant->save($this->request->data)) {
				$this->Session->setFlash(__('The tenant has been saved'),
                                            'default',
                                            array('class' => 'success'));
                                // if I am superadmin, and I just updated the current
                                // tenant, then update the tenant name in the session
                                // so that it correctly appears in the title bar
                                $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
                                $myTenantId = $this->Session->read('Auth.User.tenant_id');
                                if ($myRoletypeId == 1 &&
                                        $this->request->data['Tenant']['id'] == $myTenantId ) {
                                    $this->Session->write('Tenant.name', $this->request->data['Tenant']['name']);
                                }
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tenant could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Tenant->read(null, $id);
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
		$this->Tenant->id = $id;
		if (!$this->Tenant->exists()) {
			throw new NotFoundException(__('Invalid tenant'));
		}
		if ($this->Tenant->delete()) {
			$this->Session->setFlash(__('Tenant deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tenant was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
