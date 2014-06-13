<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
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
                <?php if ($forced_change) : ?>
                <p>Your password has previously been reset. You must now enter a new password.</p>
                <?php endif; ?>
	<?php
                echo $this->Form->input('id');
                // The next field is needed to keep data between failed saves ...
                echo $this->Form->input('User.name', array('type' => 'hidden'));
                echo $this->Form->input('User.first_name', array('type' => 'hidden'));
		echo $this->Form->input('new_password', array('type'=>'password'));
                // Additional field for password verification...
                echo $this->Form->input('password_confirmation',array('type'=>'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
            <?php if (!$forced_change) : ?>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <li><?php if ($myUserId == $user['User']['id']) {
                    echo $this->Html->link(__('View my details'), array('action' => 'view', $user['User']['id']));
                } else {
                        echo $this->Html->link(__('View') . ' ' . $user['User']['first_name'] . '\'s details',
                            array('action' => 'view', $user['User']['id']));
                }
                ?> </li>
            <?php endif; ?>
	</ul>
</div>
