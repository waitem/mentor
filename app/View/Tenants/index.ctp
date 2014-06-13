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
<div class="tenants index">
	<h2><?php echo __('Tenants');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($tenants as $tenant): ?>
	<tr>
		<td><?php echo h($tenant['Tenant']['id']); ?>&nbsp;</td>
		<td><?php echo h($tenant['Tenant']['name']); ?>&nbsp;</td>
		<td><?php echo h($tenant['Tenant']['created']); ?>&nbsp;</td>
		<td><?php echo h($tenant['Tenant']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tenant['Tenant']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tenant['Tenant']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tenant['Tenant']['id']), null, __('Are you sure you want to delete # %s?', $tenant['Tenant']['id'])); ?>
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
                <?php echo '<li>' . $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')) . '</li>'; ?>
		<li><?php echo $this->Html->link(__('New Tenant'), array('action' => 'add')); ?></li>
                <li><?php echo $this->Html->link(__('Configure E-mail'), array('controller' => 'tenants', 'action' => 'email_config')); ?></li>
	</ul>
</div>
