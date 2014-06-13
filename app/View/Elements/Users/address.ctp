<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) )
            || $myUserId == $user['User']['id']) {
        if (in_array($view, array('edit'))) {
                echo $this->Form->input('UserAddress.id', array('type' => 'hidden'));
                echo $this->Form->input('UserAddress.street',
                        array('label' => __('House number and street')));
                echo $this->Form->input('UserAddress.suburb');
                echo $this->Form->input('UserAddress.state',
                        array(
                            'type' => 'select',
                            'options' => array(
                                'ACT' => 'ACT',                                                
                                'NSW' => 'NSW',
                                'NT'  => 'NT',
                                'QLD' => 'QLD',
                                'SA'  => 'SA',
                                'TAS' => 'TAS',
                                'VIC' => 'VIC',
                                'WA'  => 'WA',
                                ),
                            'default' => 'QLD'));
                echo $this->Form->input('UserAddress.postcode');
        } elseif (in_array($view, array('view'))) {
        	if (! empty($htmlHeader)) {
        		echo '<' . $htmlHeader . '>' ;
        		echo __('Address');
        		echo '</' . $htmlHeader . '>' ;
        	}

        	if (! empty($htmlDetail)) {
            	echo '<' . $htmlDetail . '>' ;
        	}
            if (strlen($user['UserAddress']['street'] > 0)) {
                echo h($user['UserAddress']['street']) . (! empty($separator) ? $separator : ', ' );
            }
            echo h($user['UserAddress']['suburb']) . (! empty($separator) ? $separator : ' ' ) .
                    h($user['UserAddress']['state']) . (! empty($separator) ? $separator : ' ' ) .
                    h($user['UserAddress']['postcode']) . (! empty($separator) ? '' : '&nbsp;' );
            if (! empty($htmlDetail)) {
            	echo '</' . $htmlDetail . '>' ;
            }
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/address.ctp";
        }

    }
?>

