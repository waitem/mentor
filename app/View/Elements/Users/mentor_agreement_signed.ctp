<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

    if ($view == 'edit') {            
        echo '<div class="showHideDate">';
        echo $this->Form->input('MentorExtraInfo.agreement_signed');
        echo $this->Form->input('MentorExtraInfo.date_agreement_signed',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
        echo '</div>';
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Agreement Signed') ;    
            } else {
                echo $this->Paginator->sort( 'MentorExtraInfo.date_agreement_signed', __('Mentor Agreement Signed'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            if ($user['MentorExtraInfo']['agreement_signed'] == 1) {
                echo h($this->Custom->longDate($user['MentorExtraInfo']['date_agreement_signed']));
            } else {
                echo 'Not yet';
            }
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentor_agreement_signed.ctp";
    }

?>

