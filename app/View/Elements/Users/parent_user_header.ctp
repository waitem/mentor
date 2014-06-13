<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    // $parentView is defined by a call to getView from the view_user action in the controller
    if ($view == 'view' && $parentView != 'none') {
        echo "<$htmlType>";
        if ($user['Roletype']['name'] == 'Admin')
            echo __('Superadmin');
        elseif ($user['Roletype']['name'] == 'Coordinator')
            echo __('Admin');
        elseif ($user['Roletype']['name'] == 'Mentor')
            echo __('Coordinator');
        elseif ($user['Roletype']['name'] == 'Mentee')
            echo __('Primary Mentor');
        else {
            echo __('Parent User');         
        }
        echo "</$htmlType>";
    } else {
        if ($view == 'view' && $parentView == 'none') {
            // do nothing
        } else {
            echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/parent_user_detail.ctp";
        }
    }
?>
