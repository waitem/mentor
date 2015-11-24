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
        echo $this->Form->input('MenteeExtraInfo.signed_on_to_chamber', array('label' => 'Signed on to Chamber'));
        echo $this->Form->input('MenteeExtraInfo.date_signed_on_to_chamber',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
        echo '</div>';
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Signed on to Chamber') ;    
            } else {
                echo $this->Paginator->sort( 'MenteeExtraInfo.date_signed_on_to_chamber', __('Signed on to Chamber'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            if ($user['MenteeExtraInfo']['signed_on_to_chamber'] == 1) {
                echo h($this->Custom->longDate($user['MenteeExtraInfo']['date_signed_on_to_chamber']));
            } else {
                echo 'Not yet';
            }
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_signed_on_to_chamber.ctp";
    }

?>

