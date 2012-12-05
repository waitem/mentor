<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 * This version: Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
      
    public function dateNotInFuture($data, $field) {
            if (strtotime( $data[$field]) < time() ) {
                return true;
            } else {
                return 'The date must not be in the future';
            }
    }
    
    public function dateNotInPast($data, $field) {
            if (strtotime( $data[$field]) >= strtotime(date('Y-m-d')) ) {
                return true;
            } else {
                return 'The date must not be in the past';
            }
    }
    
    public function dateSameOrLater($data, $model, $first_date_field, $last_date_field) {
            if (strtotime( $this->data[$model][$last_date_field]) >= strtotime($this->data[$model][$first_date_field]) ) {
                return true;
            } else {
                return false;
            }
    }
    
    public function checkDate( $data, $model, $checkbox_field, $date_field, $message ) {
            if ( $this->data[$model][$checkbox_field] && strlen($this->data[$model][$date_field]) == 0) {
                $this->invalidate($date_field, $message );
            }
            return true;
    }
    
    public function notChecked( $data, $model, $checkbox_field, $date_field, $message ) {
        if ( ! $this->data[$model][$checkbox_field] && strlen($this->data[$model][$checkbox_field]) > 0) {
            $this->invalidate($checkbox_field, $message );
        }
        return true;
    }
}
