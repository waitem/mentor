<?php
/* /app/View/Helper/CustomHelper.php (using other helpers) */

/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 */

App::uses('AppHelper', 'View/Helper');

class CustomHelper extends AppHelper {
    public $helpers = array('Time');

    public function longDate($dateString) {
        // Use the Time helper to output
        // formatted data:
        return $this->Time->format('d/m/Y', $dateString);
    }
}
?>

