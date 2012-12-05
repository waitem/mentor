<?php
/*
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    
    if ($view == 'edit') {
        echo $this->Form->input('MentorExtraInfo.id');
        echo $this->Form->input('MentorExtraInfo.max_mentees');
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo __('Max Mentees') ;    
            } else {
                echo $this->Paginator->sort( 'MentorExtraInfo.max_mentees', __('Max Mentees'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            echo h($user['MentorExtraInfo']['max_mentees']) . '&nbsp';
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentor_max_mentees.ctp";
    }
    
?>

