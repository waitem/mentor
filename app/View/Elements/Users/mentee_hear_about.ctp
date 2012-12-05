<?php
/*
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    // This is only shown when the user being shown is a mentee
    if ($user['User']['roletype_id'] == MENTEE && 
            // and we are important enough
            (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) )
            ) {
        if (in_array($view, array('edit'))) {
                echo $this->Form->input('MenteeExtraInfo.id');
                echo $this->Form->input('MenteeExtraInfo.where_did_they_hear_about_us');
        } elseif (in_array($view, array('view'))) {
            echo '<dt>' . __('Heard about us from') . '</dt>';
            echo '<dd>' ;
            echo h($user['MenteeExtraInfo']['where_did_they_hear_about_us']);
            echo '&nbsp' . '</dd>';
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_hear_about.ctp";
        }

    }
?>

