<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

	//$label = $newRoletypeName . ' ' . __('Status');
		$label = __('Status');
        //if (in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {                
            if (in_array($view, array('add', 'edit'))) {
                 // If we are editing, we can't edit our own active flag
                 if ((isset($user['User']['id']) && ($myUserId == $user['User']['id']))
                 	|| $myRoletypeId > COORDINATOR) {
                     echo $this->Form->input('user_status_id', array('type' => 'hidden'));
                 } else {
                 	if (! empty($data_theme)) {
                 		echo $this->Form->input('user_status_id', array('label' => $label, 'data-theme' => $data_theme));
                 	} else {
                    	echo $this->Form->input('user_status_id', array('label' => $label));
                 	}
                 }
            } elseif (in_array($view, array('view', 'dashboard', 'list_header', 'list_detail'))) {
            	if (in_array($view, array('view', 'list_header'))) {
	                echo '<' , $htmlHeader . '>' . $label . '</' . $htmlHeader . '>';
            	}
            	if (in_array($view, array('view', 'dashboard', 'list_detail'))) {
	                echo '<' . $htmlDetail . '>';
	                if (strlen($user['UserStatus']['name'])) {
	                	echo h($user['UserStatus']['name']);	                	
	                } else {
	                	echo 'Not set';
	                }

	                echo '</' . $htmlDetail . '>';
            	}
            } else {
                echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/status.ctp";
            }

        //}
?>
