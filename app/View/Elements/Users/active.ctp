<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

        if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {                
            if (in_array($view, array('add', 'edit'))) {
                 // If we are editing, we can't edit our own active flag
                 if (isset($user['User']['id']) && ($myUserId == $user['User']['id'])) {
                     echo $this->Form->input('active', array('type' => 'hidden'));
                 } else {
                    echo $this->Form->input('active');
                 }
            } elseif (in_array($view, array('view'))) {
                echo '<dt>' . __('Active') . '</dt>';
                echo '<dd>';
                
                if (h($user['active']) == 1) {
                    echo 'Yes';
                } else {
                    echo 'No';
                }
		echo '</dd>';
            } elseif (in_array($view, array('list_header'))) {
                echo '<th>';                
                echo __('Active');
		echo '</th>';
            } elseif (in_array($view, array('dashboard', 'list_detail'))) {
                echo '<td>';                
                if (h($user['active']) == 1) {
                    echo 'Yes';
                } else {
                    echo 'No';
                }
		echo '</td>';
            } else {
                echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/active.ctp";
            }

        }
?>
