<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
        if (in_array($view, array('edit'))) {
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.invoiced', array('label' => 'Account sent out'));
            echo $this->Form->input('MenteeExtraInfo.date_invoiced',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text',
                    )
                 );
            echo '</div>';
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.payment_received', array('label' => 'Payment received'));
            echo $this->Form->input('MenteeExtraInfo.date_payment_received',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text',
                 ));
            echo '</div>';
        } elseif (in_array($view, array('view'))) {
            echo '<dt>' . __('Account status') . '</dt>';
            if ($user['MenteeExtraInfo']['invoiced'] == 1) {
                if ($user['MenteeExtraInfo']['payment_received'] == 1) {
                    echo '<dd>' . 'Paid on ' . 
                            h($this->Custom->longDate( $user['MenteeExtraInfo']['date_payment_received'])) . 
                            '&nbsp' .	'</dd>';
                } else {
                    echo '<dd>' . 'Payment outstanding (invoice sent' . 
                            // ' ' . h($this->Time->timeAgoInWords($user['MenteeExtraInfo']['date_invoiced'], 
                            //        array('format' => ' ', 'end' => '+1 year'))) . 
                            ' on ' . 
                            h($this->Custom->longDate($user['MenteeExtraInfo']['date_invoiced'])) . 
                            ')' . '</dd>';
                }
            } else {
                echo '<dd>' . 'Invoice has not been sent out' .	'</dd>';
            }                
        } elseif (in_array($view, array('list_header'))) {
            echo '<th>' . __('Account status') . '</th>';
        } elseif (in_array($view, array('list_detail'))) {
            if ($user['MenteeExtraInfo']['invoiced'] == 1) {
                if ($user['MenteeExtraInfo']['payment_received'] == 1) {
                    echo '<td>' . 'Paid on ' . 
                            h($this->Custom->longDate( $user['MenteeExtraInfo']['date_payment_received'])) . 
                            '&nbsp' .	'</td>';
                } else {
                    echo '<td>' . 'Payment outstanding (invoice sent' . 
                            // ' ' . h($this->Time->timeAgoInWords($user['MenteeExtraInfo']['date_invoiced'], 
                            //        array('format' => ' ', 'end' => '+1 year'))) . 
                            ' on ' . 
                            h($this->Custom->longDate($user['MenteeExtraInfo']['date_invoiced'])) . 
                            ')' . '</td>';
                }
            } else {
                echo '<td>' . 'Invoice has not been sent out' .	'</td>';
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_account_info.ctp";
        }

    }
?>

