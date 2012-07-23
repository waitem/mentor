<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
        if (in_array($view, array('edit'))) {
            echo $this->Form->input('MenteeExtraInfo.id');
            echo $this->Form->input('MenteeExtraInfo.date_joined',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
        } elseif (in_array($view, array('view'))) {
            echo '<dt>' . __('Date Joined') . '</dt>' . 
                '<dd>' . h($this->Custom->longDate( $user['MenteeExtraInfo']['date_joined'])) . '&nbsp' .	'</dd>';
        } elseif (in_array($view, array('list_header'))) {
            echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.date_joined', __('Date joined')) . '</th>';
        } elseif (in_array($view, array('list_detail'))) {
            echo '<td>' . h($this->Custom->longDate( $user['MenteeExtraInfo']['date_joined'])) . '&nbsp' .	'</td>';
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_date_joined.ctp";
        }

?>

