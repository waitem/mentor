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
        echo $this->Form->input('MentorExtraInfo.id');
        echo $this->Form->input('MentorExtraInfo.date_joined',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 )
                );
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
        	if (! empty($htmlHeader)) {
            	echo '<' . $htmlHeader . '>' ;
        	}
            if ( $view == 'view') {
                echo __('Date Joined') ;    
            } else {
                echo $this->Paginator->sort( 'MentorExtraInfo.date_joined', __('Date joined'));    
            }
            if (! empty($htmlHeader)) {
            	echo '</' . $htmlHeader . '>' ;
            }      
        }
        if (in_array($view, array('view', 'list_detail'))) {
        	if (! empty($htmlDetail)) {
            	echo '<' . $htmlDetail . '>' ;
        	}
            echo h($this->Custom->longDate( $user['MentorExtraInfo']['date_joined'])) . ' &nbsp';
            if (! empty($htmlDetail)) {
            	echo '</' . $htmlDetail . '>' ;
            }
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentor_date_joined.ctp";
    }

?>

