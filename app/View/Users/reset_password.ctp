<?php
/*
 * Copyright (c) 2012-2013 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo $title_for_layout; ?></legend>
	<?php
                echo $this->Form->input('id');
                // The next field is needed to keep data between failed saves ...
                echo $this->Form->input('User.first_name', array('type' => 'hidden'));
                //echo $this->Form->input('User.name', array('type' => 'hidden'));
	?>
        <p>Are you sure that you wish to reset <?php echo $who?> password?</p>
        
        <p>After you click the 'Reset Password' button below, an e-mail containing a new temporary password will be sent to <?php echo $recipient?></p>
	</fieldset>
<?php echo $this->Form->end(__('Reset Password'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <li><?php if ($myUserId == $user['User']['id']) {
                    echo $this->Html->link(__('View my details'), array('action' => 'view', $user['User']['id']));
                } else {
                        echo $this->Html->link(__('View') . ' ' . $user['User']['first_name'] . '\'s details', 
                            array('action' => 'view', $user['User']['id']));
                }
                ?> </li>	
	</ul>
</div>
