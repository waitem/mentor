<?php
App::uses('AppController', 'Controller');
/**
 * Invoices Controller
 *
 * @property Invoice $Invoice
 */
class InvoicesController extends AppController {
	
	public function isAuthorized($user) {

		if ($this->action == 'delete') {
			if ( $this->Session->read('Roletype.id') <= SUPERADMIN) {
				return true;
			}
			$this->Auth->authError = "Sorry - Only superadmins can delete invoices";
			return false;
			
		} else {
			if ( $this->Session->read('Roletype.id') <= COORDINATOR ) {
				return true;
			}
			$this->Auth->authError = "Sorry - Only coordinators or higher can do anything with invoices";
			return false;
		}
		return false;
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$myTenantId = $this->Session->read('Auth.User.tenant_id');
		$this->Invoice->recursive = 0;
		$this->set('invoices', $this->paginate(
				array(
					'User.tenant_id' => $myTenantId,
					'User.roletype_id' => MENTEE,
		)));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		$this->set('invoice', $this->Invoice->read(null, $id));
	}


	/**
	 * modify method
	 *
	 * @return void
	 */
	public function modify($id = NULL) {
		
		$myTenantId = $this->Session->read('Auth.User.tenant_id');

		if ($this->request->is('post') ||
		($this->action == 'edit' && $this->request->is('put'))
		) {
			if ($this->action == 'add') {
				$this->Invoice->create();
			}
			// set the tenant id
			$this->request->data['Invoice']['tenant_id'] = $myTenantId;
			if ($this->Invoice->save($this->request->data)) {
				$this->Session->setFlash(__('The invoice has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invoice could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Invoice->read(null, $id);
		}
		
		// if adding an invoice, set the number to the maximum one found plus one
		if ($this->action == 'add') {
			$max_invoice_number = $this->Invoice->find('first',
					array(
					'conditions' => array(
							'Invoice.tenant_id' => $myTenantId,
					),
					'fields' => array('MAX(Invoice.invoice_number) AS invoice_number', '*'),
					'group by' => 'Invoice.tenant_id',
							)
					);
			// if one found ...
			if (array_key_exists('0', $max_invoice_number)) {
				$this->request->data['Invoice']['invoice_number'] = $max_invoice_number['0']['invoice_number'] + 1;
			}
			// and initialise the date to today
			$this->request->data['Invoice']['date_invoiced'] = date('Y-m-d');
		}
		
		// The search conditions for users to list
		$conditions = array(
				'User.tenant_id' => $myTenantId,
				'User.roletype_id' => MENTEE,
				'UserStatus.active' => true,
		);
		if (array_key_exists('user_id', $this->request->params['named'])) {
			$user_id = $this->request->params['named']['user_id'];
			// append to search conditions
			$conditions = $conditions + array('User.id' => $user_id);
		};
		
		$this->Invoice->User->Behaviors->load('Containable');
		// $users = $this->Invoice->User->find('list');
		// Debugger::dump($users);

		$results = $this->Invoice->User->find('all', 
				array(
						'conditions' => $conditions,
						// Following contain is needed in order to allow the UserStatus.active condition above
						'contain' => array( 
							'UserStatus',
						) 
				));
		// if no users found, then bomb out
		if (!count($results)) {
			throw new InternalErrorException(__('No matching user(s) found to invoice!'));
		}
		// Convert the results to a list
		// Initialise array of users
		$users = array();
		foreach ($results as $result) {
			$users[ $result['User']['id'] ] = $result['User']['name']; 
		}
		//Debugger::dump($users);
		$this->set(compact('users'));
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
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
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
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		if ($this->Invoice->delete()) {
			$this->Session->setFlash(__('Invoice deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Invoice was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
