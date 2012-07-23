<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<?php 
    if ($userExpenseClaim['UserExpenseClaim']['reimbursed']) {
        echo 'Reimbursed on ' . h($this->Custom->longDate($userExpenseClaim['UserExpenseClaim']['date_reimbursed']));
    } else {
        echo 'Awaiting reimbursement';
    }
?>
