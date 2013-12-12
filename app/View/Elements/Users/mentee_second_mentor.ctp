<?php
/*
 * Copyright (c) 2012-2013 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    // This is only shown when the user being shown is a mentee
    if ($user['User']['roletype_id'] == MENTEE && 
            // and we are important enough
            (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) )
            // or we are the mentee ourself
            || $myUserId == $user['User']['id'])
            ) {
        if (in_array($view, array('edit'))) {
                echo $this->Form->input('User.second_mentor_id', $element_params);
        } elseif (in_array($view, array('view'))) {
        	echo '<' . $htmlHeader . '>' ;
            echo __('Additional Mentor');
            echo '</' . $htmlHeader . '>' ;
            echo '<' . $htmlDetail . '>' ;
            // if no second_mentor_id then just show "None"
            if (!$user['User']['second_mentor_id']) {
                echo 'None';
            } else {
                // use view for our "descendants"
                // or if we are a mentor/mentee,, for our parent and grandparent
                if ($myRoletypeId < $user['Roletype']['id'] ||
                        $parentView == 'view') {
                    echo $this->Html->link($user['SecondMentor']['name'], array('controller' => 'users', 'action' => 'view', $user['User']['second_mentor_id']));
                } else {
                    echo $this->Html->link($user['SecondMentor']['name'], array('controller' => 'users', 'action' => 'view_profile', $user['User']['second_mentor_id']));
                }
            }
            echo '&nbsp';
            echo '</' . $htmlDetail . '>' ;
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_second_mentor_id.ctp";
        }

    }
?>

