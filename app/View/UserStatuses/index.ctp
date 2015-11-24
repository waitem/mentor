<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
?>
<div class="userStatuses index">
	<h2><?php echo __('User Statuses'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('number'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('roletype_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($userStatuses as $userStatus): ?>
	<tr>
		<td><?php echo h($userStatus['UserStatus']['number']); ?>&nbsp;</td>
		<td><?php echo h($userStatus['UserStatus']['name']); ?>&nbsp;</td>
		<td><?php echo h($userStatus['UserStatus']['active']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userStatus['Roletype']['name'], array('controller' => 'roletypes', 'action' => 'view', $userStatus['Roletype']['id'])); ?>
		</td>
		<td><?php echo h($this->Custom->formatTimestamp($userStatus['UserStatus']['created'])); ?>&nbsp;</td>
		<td><?php echo h($this->Custom->formatTimestamp($userStatus['UserStatus']['modified'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userStatus['UserStatus']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userStatus['UserStatus']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userStatus['UserStatus']['id']), null, __('Are you sure you want to delete # %s?', $userStatus['UserStatus']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
		<li><?php echo $this->Html->link(__('New User Status'), array('action' => 'add')); ?></li>
	</ul>
</div>
