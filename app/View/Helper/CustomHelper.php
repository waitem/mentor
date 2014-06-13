<?php
/* /app/View/Helper/CustomHelper.php (using other helpers) */

/*
 * Copyright (c) 2012-2014 Mark Waite
 */

App::uses('AppHelper', 'View/Helper');

class CustomHelper extends AppHelper {
    public $helpers = array('Time', 'Session');

    public function longDate($dateString) {
        // Use the Time helper to output
        // formatted data:
        return $this->Time->format('d/m/Y', $dateString);
    }
    
    public function formatTimestamp($timestamp) {
        // FIXME use localisation format
        date_default_timezone_set($this->Session->read('Auth.User.timezone'));
        return date('d/m/Y H:i:s', $timestamp);
    }
    
}
?>

