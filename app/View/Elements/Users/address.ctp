<?php
/*
 * Copyright (c) 2012 Mark Waite
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
            echo '<dt>' . __('Address') . '</dt>';
            echo '<dd>' ;
            if (strlen($user['UserAddress']['street'] > 0)) {
                echo h($user['UserAddress']['street']) . ', ';
            }
            echo h($user['UserAddress']['suburb']) . ' ' .
                    h($user['UserAddress']['state']) . ' ' .
                    h($user['UserAddress']['postcode']) .
                            '&nbsp' .	'</dd>';

        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/address.ctp";
        }

    }
?>

