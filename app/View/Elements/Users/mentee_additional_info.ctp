<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
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
            ) ) {
        if (in_array($view, array('edit'))) {
                echo $this->Form->input('MenteeExtraInfo.id');
                echo $this->Form->input('MenteeExtraInfo.additional_info', array('class' => 'profile'));
        } elseif (in_array($view, array('view'))) {
        	if (! empty($htmlHeader)) {
        		echo '<' . $htmlHeader . '>' ;
            	echo __('Meeting notes');
            	echo '</' . $htmlHeader . '>' ;
        	}
        	if (! empty($htmlDetail)) {
            	echo '<' . $htmlDetail . '>' ;
        	}
            echo '<div class="profile">';
            // if (strlen($user['MenteeExtraInfo']['additional_info']) > 70) {
               // echo h(substr($user['MenteeExtraInfo']['additional_info'], 0, 70)) . ' ...';
            // } else {
            	if (! empty($user['MenteeExtraInfo']['additional_info'])) {
                echo nl2br( h($user['MenteeExtraInfo']['additional_info']));
            	} else {
            		echo "No meeting notes recorded yet ...";
            	}
            //}
            echo '</div>';
            if (! empty($htmlDetail)) {
            	echo '</' . $htmlDetail . '>' ;
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_additional_info.ctp";
        }

    }
?>

