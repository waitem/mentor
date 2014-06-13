<?php
/*
 * Copyright (c) 2012-2014 Mark Waite
 */
?>
<div class="menteeSurveys index">
	<h2><?php echo __('Mentee Surveys');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('date_sent');?></th>
			<th><?php echo 'Status';?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($menteeSurveys as $menteeSurvey): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($menteeSurvey['User']['name'], array('controller' => 'users', 'action' => 'view', $menteeSurvey['User']['id'])); ?>
		</td>
		<td><?php echo h($this->Custom->longDate( $menteeSurvey['MenteeSurvey']['date_sent'])); ?>&nbsp;</td>
                <?php if ($menteeSurvey['MenteeSurvey']['returned'] == true): ?>
		<td><?php echo 'Returned on ' . h($this->Custom->longDate( $menteeSurvey['MenteeSurvey']['date_returned'])); ?>&nbsp;</td>
                <?php else: ?>
                <td><?php echo 'Not yet returned (' . floor((time() - strtotime($menteeSurvey['MenteeSurvey']['date_sent']))/86400) . ' days)'; ?>&nbsp;</td>
                <?php endif; ?>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $menteeSurvey['MenteeSurvey']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $menteeSurvey['MenteeSurvey']['id']), null, __('Are you sure you want to delete # %s?', $menteeSurvey['MenteeSurvey']['id'])); ?>
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
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <li><?php echo $this->Html->link(__('Mentees'), array('controller' => 'users', 'action' => 'list_mentees')); ?></li>
		<li><?php echo $this->Html->link(__('New Mentee Survey'), array('action' => 'add')); ?></li>
	</ul>
</div>
