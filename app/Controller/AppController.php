<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * 
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 * 
 * This version: Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
        'Session',
        'Auth'=>array(
            // The screen to go to after a user logs in, if they weren't already
            // trying to access another screen already
            // This can be defined (overridden) by the UsersController login action
            // in order to take the user to another "personal" start page
            'loginRedirect'=>array('controller'=>'users', 'action'=>'dashboard'),
            // Where to send users when they logout ...
            'logoutRedirect'=>array('controller'=>'pages', 'action'=>'logged_out'),
            'authError'=>'Sorry, but you are not allowed to do that',            
            'authorize'=>array('Controller'),
            
            // use the email field for the "username" part of form authorisation
            'authenticate' => array(
                'Form' => array(
                    'fields'=>array('username'=>'email')
                )
            )
        )
    );
    
    // This determines which screens / functions a user is authorised
    // to use. Default initially to everything.
    // FIXME: We may want to default to nothing later :)
    public function isAuthorized($user) {
        return false;
    }
    
    public function beforeFilter() {

        if ($this->Session->check('Roletype.name')) {
            $this->set('myRoletypeName', $this->Session->read('Roletype.name'));
        }
        if ($this->Session->check('Roletype.id')) {
            $this->set('myRoletypeId', $this->Session->read('Roletype.id'));
        }
        if ($this->Session->check('Auth.User.id')) {
            $this->set('myUserId', $this->Session->read('Auth.User.id'));
        }
        
    }

}
