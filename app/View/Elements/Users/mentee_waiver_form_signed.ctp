<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

    if ($view == 'edit') {            
        //echo $this->Form->input('MenteeExtraInfo.waiver_form_signed', array('label' => 'Waiver Form signed'));
        echo $this->Form->input('MenteeExtraInfo.date_waiver_form_signed',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Waiver Form Signed') ;    
            } else {
                echo $this->Paginator->sort( 'MenteeExtraInfo.date_waiver_form_signed', __('Mentor Agreement Signed'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            if (strlen($user['MenteeExtraInfo']['date_waiver_form_signed']) ) {
                echo h($this->Custom->longDate($user['MenteeExtraInfo']['date_waiver_form_signed']));
            } else {
                echo 'Not yet';
            }
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_waiver_form_signed.ctp";
    }

?>

