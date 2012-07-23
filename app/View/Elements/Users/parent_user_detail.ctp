<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if ($view == 'list_users' ||
         // $parentView is defined by a call to getView from the view_user action in the controller
         ($view == 'view' && $parentView != 'none') ) {
        echo "<$htmlType>";
        // if the parent has not been assigned (i.e. a mentee does not yet have a mentor)
        // then don't show a link to the "Unassigned" user
        if ($user['User']['parent_id'] == 0) {
                echo __('Unassigned') ;
                // If a mentee, show how any days since they joined they have been waiting
                if ($user['Roletype']['name'] == 'Mentee') {
                    echo ' ' . floor((time() - strtotime($user['MenteeExtraInfo']['date_joined']))/86400) . ' days';
                }
                
        } else {
            // use view for our "descendants"
            // or if we are a mentor/mentee,, for our parent and grandparent
            if ($myRoletypeId < $user['Roletype']['id'] ||
                    $parentView == 'view') {
                echo $this->Html->link($user['ParentUser']['name'], array('controller' => 'users', 'action' => 'view', $user['ParentUser']['id']));
            } else {
                echo $this->Html->link($user['ParentUser']['name'], array('controller' => 'users', 'action' => 'view_profile', $user['ParentUser']['id']));
            }
        }
        echo "</$htmlType>";
    } else {
        if ($view == 'view' && $parentView == 'none') {
            // do nothing
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/parent_user_detail.ctp";
        }
    }
?>
