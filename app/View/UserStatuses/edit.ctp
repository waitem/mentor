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
<div class="userStatuses form">
<?php echo $this->Form->create('UserStatus'); ?>
	<fieldset>
		<legend><?php echo __('Edit User Status'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('number');
		echo $this->Form->input('name');
		echo $this->Form->input('active');
		echo $this->Form->input('roletype_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UserStatus.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('UserStatus.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Statuses'), array('action' => 'index')); ?></li>
	</ul>
</div>
