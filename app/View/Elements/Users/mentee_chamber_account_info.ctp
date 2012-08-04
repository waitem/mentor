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
            echo $this->Form->input('MenteeExtraInfo.coordinator_invoice_sent', 
                    array('label' => 'Chamber invoice sent'));
            echo $this->Form->input('MenteeExtraInfo.date_coordinator_invoice_sent',
                array(
                    'label' => 'Date chamber invoice sent',
                    'class'=>'datepicker', 
                    'type'=>'text',
                    )
                 );
            echo '</div>';
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.balance_paid', 
                    array('label' => 'Balance of chamber invoice paid'));
            echo $this->Form->input('MenteeExtraInfo.date_balance_paid',
                array(
                    'label' => 'Date balance of chamber invoice paid',
                    'class'=>'datepicker', 
                    'type'=>'text',
                 ));
            echo '</div>';
        } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
            if (in_array($view, array('view', 'list_header'))) {
                echo '<' . $htmlHeader . '>' ;
                echo __('Chamber account status');
                echo '</' . $htmlHeader . '>' ;
            }
            if (in_array($view, array('view', 'list_detail'))) {
                echo '<' . $htmlDetail . '>' ;
                if ($user['MenteeExtraInfo']['coordinator_invoice_sent'] == 1) {
                    if ($user['MenteeExtraInfo']['balance_paid'] == 1) {
                        echo 'Balance paid on ' . 
                            h($this->Custom->longDate( $user['MenteeExtraInfo']['date_balance_paid']));
                    } else {
                        echo 'Payment of balance outstanding (Chamber invoice sent on ' . 
                            h($this->Custom->longDate($user['MenteeExtraInfo']['date_coordinator_invoice_sent'])) . ')';
                    }
                } else {
                    echo 'Chamber has not yet been invoiced';
                }
                echo '</' . $htmlDetail . '>' ;
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_chamber_account_info.ctp";
        }

    }
?>

