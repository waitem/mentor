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
            // or we are the mentee ourself
            || $myUserId == $user['User']['id'])
            ) {
        if (in_array($view, array('edit'))) {
                echo $this->Form->input('MenteeExtraInfo.id');
                echo $this->Form->input('MenteeExtraInfo.company_name');
                echo $this->Form->input('MenteeExtraInfo.company_web_site', array('label' => 'Company Web Site (without the "http://" bit)'));
        } elseif (in_array($view, array('view'))) {
            echo '<dt>' . __('Company name') . '</dt>';
            echo '<dd>' ;
            echo h($user['MenteeExtraInfo']['company_name']);
            echo '&nbsp' . '</dd>';
            echo '<dt>' . __('Web site') . '</dt>';
            echo '<dd>' ;
            if (strlen($user['MenteeExtraInfo']['company_web_site']) > 0) {
                echo $this->Text->autoLinkUrls('http://' . $user['MenteeExtraInfo']['company_web_site'], array('target' => '_blank'));                
            }
            echo '&nbsp' . '</dd>';
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_company.ctp";
        }

    }
?>

