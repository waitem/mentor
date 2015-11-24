<?php
App::uses('AppController', 'Controller');
/**
 * Audits Controller
 *
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @property Audit $Audit
 */
class AuditsController extends AppController {
    
    public $paginate = array(
        // other keys here.
        //'maxLimit' => 12,
        'order' => array(
            'Audit.created' => 'desc'
        )
    );


    public function isAuthorized($user) {

        // Allow everyone down to coordinators to view audit data
        if ($this->Session->read('Auth.User.roletype_id') <= COORDINATOR) {
            return true;
        } else {
            $this->Auth->authError = "Sorry - you are not allowed do that";
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
            
                $myTenantId = $this->Session->read('Auth.User.tenant_id');
                $myRoletypeId = $this->Session->read('Auth.User.roletype_id');
                
                // We need to pick up the UserAffected as well as the AuditDeltas
		$this->Audit->recursive = 1;
                
                // Only show audit records from our own tenant
                // and changes made by users with a role the same or lower than our own
                // Write directly to the 'conditions' element in order to 
                // avoid overwriting the 'sort' element already set in the model
                $this->paginate['conditions'] = array(
                    'Audit.tenant_id' => $myTenantId,
                    'ChangedBy.roletype_id >=' => $myRoletypeId
                    );
                
                $audits = $this->paginate();
		$this->set('audits', $audits);
		$this->set('title_for_layout', 'Audit Log');
                //Debugger::dump($audits);

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Audit->id = $id;
		if (!$this->Audit->exists()) {
			throw new NotFoundException(__('Invalid audit'));
		}
		$this->set('audit', $this->Audit->read(null, $id));
		$this->set('title_for_layout', 'Audit Log Detail');
	}


}
