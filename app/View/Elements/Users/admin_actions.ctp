<?php
/*
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
?>
            <?php
            if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    if ( $myRoletypeName ==  'Superadmin' && $myUserId == $user['User']['id']) {
                        echo '<li>' . $this->Html->link(__('Tenants'), array('controller' => 'tenants', 'action' => 'index')) . '</li>';
                    }                
                    if ( $myRoletypeName ==  'Superadmin' && 
                            ($myUserId == $user['User']['id']  || $user['User']['roletype_id'] == ADMIN )
                            ) {
                        echo '<li>' . $this->Html->link(__('Admins'), array('controller' => 'users', 'action' => 'list_admins')) . '</li>';
                    }
                    if ( in_array( $myRoletypeName, array( 'Superadmin', 'Admin') ) && 
                            ( $myUserId == $user['User']['id'] || $user['User']['roletype_id'] == COORDINATOR )
                            ) {
                        echo '<li>' . $this->Html->link(__('Coordinators'), array('controller' => 'users', 'action' => 'list_coordinators')) . '</li>';
                    }
                    // if we are viewing a mentor, then also offer to list all mentors
                    if ($myUserId == $user['User']['id'] || $user['User']['roletype_id'] == MENTOR ) {
                        echo '<li>' . $this->Html->link(__('Mentors'), array('controller' => 'users', 'action' => 'list_mentors')) . '</li>';
                    // if we are viewing a mentee, then also offer to list all mentees
                    }
                    if ($myUserId == $user['User']['id'] || $user['User']['roletype_id'] == MENTEE) {
                        echo '<li>' . $this->Html->link(__('Mentees'), array('controller' => 'users', 'action' => 'list_mentees')) . '</li>';
                    }
                }
            ?>
