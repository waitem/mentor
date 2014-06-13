<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
		$short_label = __('Joined');
		$long_label = __('Date ') . $short_label . (' /<br />First invoice paid');
        if (in_array($view, array('edit'))) {
            echo $this->Form->input('MenteeExtraInfo.id');
            echo $this->Form->input('MenteeExtraInfo.date_joined',
                array(
                    'class'=>'datepicker', 
                    'type'=>'text',
               		'label' => $long_label,
                 ));
        } elseif (in_array($view, array('view'))) {
        	echo '<' . $htmlHeader . '>' ;
            echo $long_label;
            echo '</' . $htmlHeader . '>' ;
            echo '<' . $htmlDetail . '>' ;
            echo h($this->Custom->longDate( $user['MenteeExtraInfo']['date_joined'])) . '&nbsp';
            echo '</' . $htmlDetail . '>' ;
        } elseif (in_array($view, array('list_header'))) {
            echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.date_joined', $short_label) . '</th>';
        } elseif (in_array($view, array('list_detail'))) {
            echo '<td>' . h($this->Custom->longDate( $user['MenteeExtraInfo']['date_joined'])) . '&nbsp' .	'</td>';
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_date_joined.ctp";
        }

?>

