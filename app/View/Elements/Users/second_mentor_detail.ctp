<?php
/*
 * Copyright (c) 2012-2018 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if ($view == 'list_users' ||
         // $parentView is defined by a call to getView from the view_user action in the controller
         ($view == 'view' && $parentView != 'none') ) {
    	if (! empty($htmlType)) {
    		echo "<$htmlType>";
    	}
        // if the parent has not been assigned (i.e. a mentee does not yet have a mentor)
        // then don't show a link to the "Unassigned" user
        if ($user['User']['second_mentor_id'] == 0) {
                echo __('Unassigned') ;
        } else {
            // use view for our "descendants"
            // or if we are a mentor/mentee,, for our parent and grandparent
            if (($myRoletypeId < $user['Roletype']['id'] ||
                    $parentView == 'view') && $myUserId != $user['User']['second_mentor_id'])  {
                echo $this->Html->link($user['SecondMentor']['name'], array('controller' => 'users', 'action' => 'view', $user['SecondMentor']['id']));
            } else {
                echo $this->Html->link($user['SecondMentor']['name'], array('controller' => 'users', 'action' => 'view_profile', $user['SecondMentor']['id']));
            }
        }
        if (! empty($htmlType)) {
        	echo "</$htmlType>";
        }
    } else {
        if ($view == 'view' && $parentView == 'none') {
            // do nothing
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/second_mentor_detail.ctp";
        }
    }
?>
