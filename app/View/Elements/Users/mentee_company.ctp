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
                echo $this->Form->input('MenteeExtraInfo.id');
                echo $this->Form->input('MenteeExtraInfo.company_name');
                echo $this->Form->input('MenteeExtraInfo.company_web_site', array('label' => 'Company Web Site (without the "http://" bit)'));
        } elseif (in_array($view, array('view'))) {
        	echo '<' . $htmlHeader . '>' ;
            echo __('Company name') ;
            echo '</' . $htmlHeader . '>' ;
            echo '<' . $htmlDetail . '>' ;
            echo h($user['MenteeExtraInfo']['company_name']);
            echo '&nbsp' ;
            echo '</' . $htmlDetail . '>' ;
            echo '</' . $htmlRow . '>' ;
            echo '<' . $htmlRow . '>' ;
            echo '<' . $htmlHeader . '>' ;
            echo __('Web site');
            echo '</' . $htmlHeader . '>' ;
            echo '<' . $htmlDetail . '>' ;
            if (strlen($user['MenteeExtraInfo']['company_web_site']) > 0) {
                echo $this->Text->autoLinkUrls('http://' . $user['MenteeExtraInfo']['company_web_site'], array('target' => '_blank'));                
            }
            echo '&nbsp';
            echo '</' . $htmlDetail . '>' ;
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_company.ctp";
        }

    }
?>

