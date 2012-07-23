<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<div class="users dashboard">
    
	<h2><?php echo $title_for_layout;?></h2>
    <div class="emails">
	<?php
        $nocomma = true;
	foreach ($users as $user) {
            if ($nocomma) {
                $nocomma = false;
            } else {
                echo ', ';
            }
                echo h('"' . $user['User']['name'] . '"');
                echo h('<' . $user['User']['email'] . '>');
        }
        ?>
    </div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <?php if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ): ?>
                    <li><?php echo $this->Html->link( $roletype. 's', 
                            array('controller' => 'users', 'action' => 'list_' . strtolower($roletype) . 's')); ?></li>                    
                <?php endif; ?>
                    
	</ul>
</div>
