<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

    if ($view == 'edit') {            
        echo '<div class="showHideDate">';
        echo $this->Form->input('MenteeExtraInfo.statement_of_purpose_sent', array('label' => 'Statement of Purpose sent'));
        echo $this->Form->input('MenteeExtraInfo.date_statement_of_purpose_sent',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
        echo '</div>';
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Statement of Purpose Sent') ;    
            } else {
                echo $this->Paginator->sort( 'MenteeExtraInfo.date_statement_of_purpose_sent', __('Statement of Purpose Sent'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            if ($user['MenteeExtraInfo']['statement_of_purpose_sent'] == 1) {
                echo h($this->Custom->longDate($user['MenteeExtraInfo']['date_statement_of_purpose_sent']));
            } else {
                echo 'Not yet';
            }
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_statement_of_purpose_sent.ctp";
    }

?>

