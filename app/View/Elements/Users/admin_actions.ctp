<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 *
 * Author(s): See AUTHORS.txt
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
?>
            <?php
            if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    if ( $myRoletypeName ==  'Superadmin') {
                        echo '<li>' . $this->Html->link(__('Tenants'), array('controller' => 'tenants', 'action' => 'index')) . '</li>';
                        echo '<li>' . $this->Html->link(__('User Statuses'), array('controller' => 'user_statuses', 'action' => 'index')) . '</li>';
                    }
                    if ( in_array( $myRoletypeName, array( 'Superadmin', 'Admin') ) ) {
                            echo '<li>' . $this->Html->link(__('Configure E-mail'), array('controller' => 'tenants', 'action' => 'email_config')) . '</li>';
                    }
                    if ( $myRoletypeName ==  'Superadmin' ) {
                        echo '<li>' . $this->Html->link(__('Admins'), array('controller' => 'users', 'action' => 'list_admins')) . '</li>';
                    }
                    if ( in_array( $myRoletypeName, array( 'Superadmin', 'Admin') ) ) {
                            echo '<li>' . $this->Html->link(__('Coordinators'), array('controller' => 'users', 'action' => 'list_coordinators')) . '</li>';
                    }
                    echo '<li>' . $this->Html->link(__('Mentors'), array('controller' => 'users', 'action' => 'mentors_table')) . '</li>';
                    echo '<li>' . $this->Html->link(__('Mentees'), array('controller' => 'users', 'action' => 'mentees_table')) . '</li>';
                }
            ?>
