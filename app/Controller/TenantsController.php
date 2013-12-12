<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Tenants Controller
 *
 * Copyright (c) 2012-2013 Mark Waite
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

        if ($this->Session->read('Auth.User.roletype_id') == SUPERADMIN) {
            return true;
            // Admins are also allowed to update the e-mail configuration
        } elseif ($this->action == 'email_config' &&
                $this->Session->read('Auth.User.roletype_id') <= ADMIN
        ) {
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
        $this->modify($this->action);
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
        $this->modify($this->action, $id);
    }

    function modify($action, $id = null) {

        if ($this->request->is('post') ||
                (in_array($this->action, array('edit', 'email_config')) && $this->request->is('put'))) {
            if ($this->action == 'add') {
                $this->Tenant->create();
            }
            //Debugger::dump($this->request->data);
            // Test that it is possible to send an e-mail to the user
            if ($action == 'email_config') {

                // By default assume it won't work ...
                $this->request->data['EmailConfig']['tested'] = false;

                $this->email = new CakeEmail(
                                array(
                                    'transport' => 'Smtp',
                                    'from' => array($this->request->data['EmailConfig']['from_email'] => $this->request->data['EmailConfig']['from_name']),
                                    'sender' => array($this->request->data['EmailConfig']['sender_email'] => $this->request->data['EmailConfig']['sender_name']),
                                    'host' => $this->request->data['EmailConfig']['host_name'],
                                    'port' => $this->request->data['EmailConfig']['host_port'],
                                    'username' => $this->request->data['EmailConfig']['host_username'],
                                    'password' => $this->request->data['EmailConfig']['host_password'],
                                    'timeout' => 30,
                                    'client' => null,
                                    'log' => false,
                                )
                );

                if (Configure::read('debug') > 0) {
                    $recipient = 'mark.a.waite@gmail.com';
                } else {
                    $recipient = $this->request->data['Tenant']['SendTestEmailTo'];
                }

                $this->email->to($recipient);
                $this->email->subject('Congratulations! Your Mentoring Application email configuration works');
                try {
                    $result = $this->email->send(
                            "\n\nThis is a test e-mail to verify that the e-mail configuration is correct\n\n" .
                            Router::url('/', true) . "\n\n" .
                            "Best regards\n\n" .
                            $this->Session->read('Auth.User.name') . "\n" .
                            $this->request->data['Tenant']['name'] . " Business Mentors"
                    );
                } catch (Exception $exc) {
                    //echo $exc->getTraceAsString();
                    throw new InternalErrorException('Unable to send e-mail - please check e-mail configuration');
                }
                // if we get here, then we have been successful
                $this->request->data['EmailConfig']['tested'] = true;
                //Debugger::dump($result);
            }
            if ($this->Tenant->saveAssociated($this->request->data)) {
                if ($action == 'email_config') {
                    $this->Session->setFlash(__('The email configuration has been successfully verified'), 'default', array('class' => 'success'));
                    return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                } else {
                    if ($this->action == 'add') {
                        $verb = 'added';
                    } else {
                        $verb = 'updated';
                    }
                    $this->Session->setFlash(__('The tenant has been ' . $verb), 'default', array('class' => 'success'));
                    return $this->redirect(array('controller' => 'tenants', 'action' => 'index'));
                }
            } else {
                if ($action == 'email_config') {
                    $this->Session->setFlash(__('The email configuration could not be verified. Please check and try again.'));
                } else {
                    $this->Session->setFlash(__('The tenant could not be saved. Please try again.'));
                }
            }
        } elseif (in_array($action, array('edit', 'email_config'))) {
            // We come here the first time we edit a record, before trying to save it
            $this->request->data = $this->Tenant->read(null, $id);
            if ($this->action == 'email_config') {
                if (Configure::read('debug') > 0) {
                    $recipient = 'mark.a.waite@gmail.com';
                } else {
                    $recipient = $this->Session->read('Auth.User.email');
                }
                $this->request->data['Tenant']['SendTestEmailTo'] = $recipient;
            }
        }
        //Debugger::dump($this->request->data);
        $this->set('title_for_layout', 'Edit Email Configuration');
        $this->render($this->action);
    }

    public function email_config() {
        // Work out the tenant from the session
        $id = $this->Session->read('Auth.User.tenant_id');
        $this->Tenant->id = $id;
        if (!$this->Tenant->exists()) {
            throw new NotFoundException(__('Invalid tenant'));
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
