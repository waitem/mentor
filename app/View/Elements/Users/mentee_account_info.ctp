<?php
/*
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
        if (in_array($view, array('edit'))) {
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.invoiced', array('label' => 'Mentee invoice sent'));
            echo $this->Form->input('MenteeExtraInfo.date_invoiced',
                array(
                    'label' => 'Date mentee invoice sent',
                    'class'=>'datepicker', 
                    'type'=>'text',
                    )
                 );
            echo '</div>';
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.payment_received', array('label' => 'Mentee invoice paid'));
            echo $this->Form->input('MenteeExtraInfo.date_payment_received',
                array(
                    'label' => 'Date mentee invoice paid',
                    'class'=>'datepicker', 
                    'type'=>'text',
                 ));
            echo '</div>';
        } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
            if (in_array($view, array('view', 'list_header'))) {
                echo '<' . $htmlHeader . '>' ;
                echo __('Mentee account status') ;
                echo '</' . $htmlHeader . '>' ;
            }
            if (in_array($view, array('view', 'list_detail'))) {
                echo '<' . $htmlDetail . '>' ;                
                if ($user['MenteeExtraInfo']['invoiced'] == 1) {
                    if ($user['MenteeExtraInfo']['payment_received'] == 1) {
                        echo 'Paid on ' . 
                                h($this->Custom->longDate( $user['MenteeExtraInfo']['date_payment_received']));
                    } else {
                        echo 'Payment outstanding (invoice sent on ' . 
                                h($this->Custom->longDate($user['MenteeExtraInfo']['date_invoiced'])) . ')' ;
                    }
                } else {
                    echo 'Mentee has not yet been invoiced';
                }
                echo '</' . $htmlDetail . '>' ;
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_account_info.ctp";
        }

    }
?>

