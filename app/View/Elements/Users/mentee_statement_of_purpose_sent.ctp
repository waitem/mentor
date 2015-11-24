<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

$short_label = __('Contacted');
$long_label = __('Date ') . $short_label;
// this field is now being used for "Date contacted" ...
if ($user['User']['roletype_id'] == MENTEE &&
// and we are important enough
(in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) )
) {
    if ($view == 'edit') {            
        //echo $this->Form->input('MenteeExtraInfo.statement_of_purpose_sent', array('label' => 'Contacted'));
        echo $this->Form->input('MenteeExtraInfo.date_statement_of_purpose_sent',
                array(
                	'label' => $long_label,
                    'class'=>'datepicker', 
                    'type'=>'text'
                 ));
    } elseif (in_array($view, array('view', 'list_header', 'list_detail'))) {
        if (in_array($view, array('view', 'list_header'))) {
            echo '<' . $htmlHeader . '>' ;
            if ( $view == 'view') {
                echo $short_label ;    
            } else {
                echo $this->Paginator->sort( 'MenteeExtraInfo.date_statement_of_purpose_sent', __('Contacted'));    
            }
            echo '</' . $htmlHeader . '>' ;      
        }
        if (in_array($view, array('view', 'list_detail'))) {
            echo '<' . $htmlDetail . '>' ;
            if (strlen($user['MenteeExtraInfo']['date_statement_of_purpose_sent']) ) {
                echo h($this->Custom->longDate($user['MenteeExtraInfo']['date_statement_of_purpose_sent']));
            } else {
                echo 'Not yet';
            }
            echo '</' . $htmlDetail . '>' ;
        }
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/mentee_statement_of_purpose_sent.ctp";
    }
}
?>

