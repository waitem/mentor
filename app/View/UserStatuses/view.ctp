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
<div class="userStatuses view">
<h2><?php  echo __('User Status'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userStatus['UserStatus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($userStatus['UserStatus']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($userStatus['UserStatus']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($userStatus['UserStatus']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Roletype'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userStatus['Roletype']['name'], array('controller' => 'roletypes', 'action' => 'view', $userStatus['Roletype']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Custom->formatTimestamp($userStatus['UserStatus']['created'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Custom->formatTimestamp($userStatus['UserStatus']['modified'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
		<li><?php echo $this->Html->link(__('Edit User Status'), array('action' => 'edit', $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Status'), array('action' => 'delete', $userStatus['UserStatus']['id']), null, __('Are you sure you want to delete # %s?', $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Statuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Status'), array('action' => 'add')); ?> </li>
	</ul>
</div>
