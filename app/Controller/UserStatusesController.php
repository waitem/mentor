<?php
App::uses('AppController', 'Controller');
/**
 * UserStatuses Controller
 *
 * @property UserStatus $UserStatus
 */
class UserStatusesController extends AppController {

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
		$this->UserStatus->recursive = 0;
		$this->set('userStatuses', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->UserStatus->id = $id;
		if (!$this->UserStatus->exists()) {
			throw new NotFoundException(__('Invalid user status'));
		}
		$this->set('userStatus', $this->UserStatus->read(null, $id));
	}


	/**
	 * modify method
	 *
	 * @return void
	 */
	public function modify( $id = null) {
	
		$myRoletypeId = $this->Session->read('Auth.User.roletype_id');
	
		if ($this->request->is('post') || 
			($this->action == 'edit' && $this->request->is('put'))
		) {
			if ($this->action == 'add') {
				$this->UserStatus->create();
			}
			if ($this->UserStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The user status has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user status could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->UserStatus->read(null, $id);
		}
		$this->set('roletypes', $this->UserStatus->Roletype->find('list',
				array(
						'conditions' => array(
								'Roletype.id >=' => $myRoletypeId,
						)
				))) ;
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->modify();
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->UserStatus->id = $id;
		if (!$this->UserStatus->exists()) {
			throw new NotFoundException(__('Invalid user status'));
		}
		$this->modify($id);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->UserStatus->id = $id;
		if (!$this->UserStatus->exists()) {
			throw new NotFoundException(__('Invalid user status'));
		}
		if ($this->UserStatus->delete()) {
			$this->Session->setFlash(__('User status deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User status was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
