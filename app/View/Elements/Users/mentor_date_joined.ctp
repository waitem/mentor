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
        echo $this->Form->input('MentorExtraInfo.id');
        echo $this->Form->input('MentorExtraInfo.date_joined',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 )
                );
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Date Joined') ;    
            } else {
                echo $this->Paginator->sort( 'MentorExtraInfo.date_joined', __('Date joined'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            echo h($this->Custom->longDate( $user['MentorExtraInfo']['date_joined'])) . ' &nbsp';
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentor_date_joined.ctp";
    }

?>

