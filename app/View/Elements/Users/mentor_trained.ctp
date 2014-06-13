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
        echo '<div class="showHideDate">';
        echo $this->Form->input('MentorExtraInfo.trained');
        echo $this->Form->input('MentorExtraInfo.date_trained',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
        echo '</div>';
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
        	if (! empty($htmlHeader)) {
            	echo '<' . $htmlHeader . '>' ;
        	}
            if ( $view == 'view') {
                echo __('Trained') ;    
            } else {
                echo $this->Paginator->sort( 'MentorExtraInfo.date_trained', __('Trained'));    
            }
            if (! empty($htmlHeader)) {
            	echo '</' . $htmlHeader . '>' ;
            }      
        }
        if (in_array($view, array('view', 'list_detail'))) {
        	if (! empty($htmlDetail)) {
            	echo '<' . $htmlDetail . '>' ;
        	}
            if ($user['MentorExtraInfo']['trained'] == 1) {
                echo h($this->Custom->longDate($user['MentorExtraInfo']['date_trained']));
            } else {
                echo 'Not yet';
            }
            if (! empty($htmlDetail)) {
            	echo '</' . $htmlDetail . '>' ;
            }
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentor_trained.ctp";
    }

?>

