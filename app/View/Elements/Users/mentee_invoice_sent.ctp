<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

	$short_label = __('Sent');
    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
        if (in_array($view, array('edit'))) {
            echo '<div class="showHideDate">';
            echo $this->Form->input('MenteeExtraInfo.invoiced', array('label' => 'Mentee invoice sent'));
            echo $this->Form->input('MenteeExtraInfo.date_invoiced',
                array(
                    'label' => 'Date mentee invoice sent',
                    'class'=>'datepicker', 
                    'type'=>'text',
                 ));
            echo '</div>';
        } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
            if (in_array($view, array('view', 'list_header'))) {
                echo '<' . $htmlHeader . '>' ;
                echo $this->Paginator->sort( 'MenteeExtraInfo.date_invoiced', $short_label) ;
                echo '</' . $htmlHeader . '>' ;
            }
            if (in_array($view, array('view', 'list_detail'))) {
                echo '<' . $htmlDetail . '>' ;                
                if ($user['MenteeExtraInfo']['invoiced'] == 1) {
                    echo h($this->Custom->longDate( $user['MenteeExtraInfo']['date_invoiced']));
                } else {
                  	echo '-';
                }
                echo '</' . $htmlDetail . '>' ;
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_invoice_sent.ctp";
        }

    }
?>

