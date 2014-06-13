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
<div class="userAwayDates index">
	<h2><?php echo $title_for_layout;?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('first_day_away');?></th>
			<th><?php echo $this->Paginator->sort('last_day_away');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($userAwayDates as $userAwayDate): ?>
	<tr>
		<td><?php echo h($this->Custom->longDate( $userAwayDate['UserAwayDate']['first_day_away'])); ?>&nbsp;</td>
		<td><?php echo h($this->Custom->longDate( $userAwayDate['UserAwayDate']['last_day_away'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userAwayDate['UserAwayDate']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userAwayDate['UserAwayDate']['id']), null, 
                                    __('Are you sure you want to delete "Away from %s to %s"?', 
                                            $this->Custom->longDate( $userAwayDate['UserAwayDate']['first_day_away']), 
                                            $this->Custom->longDate( $userAwayDate['UserAwayDate']['last_day_away']))); ?>
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
		<li><?php echo $this->Html->link(__('Add a new date'), array('action' => 'add')); ?></li>
	</ul>
</div>
