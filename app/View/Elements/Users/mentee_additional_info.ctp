<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
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
                echo $this->Form->input('MenteeExtraInfo.additional_info', array('type' => 'textarea', 'class' => 'additional_info'));
        } elseif (in_array($view, array('view'))) {
            echo '<dt>' . __('Additional Info') . '</dt>';
            echo '<dd>' ;
            echo '<div class="additional_info">';
            // if (strlen($user['MenteeExtraInfo']['additional_info']) > 70) {
               // echo h(substr($user['MenteeExtraInfo']['additional_info'], 0, 70)) . ' ...';
            // } else {
                echo h($user['MenteeExtraInfo']['additional_info']);
            //}
            echo '</div>';
            echo '</dd>';
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_additional_info.ctp";
        }

    }
?>

