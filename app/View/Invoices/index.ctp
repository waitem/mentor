<div class="invoices index">
	<h2><?php echo __('Invoices'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('invoice_number'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id', 'Mentee'); ?></th>
			<th><?php echo $this->Paginator->sort('date_invoiced'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('date_payment_received'); ?></th>
			<th><?php echo $this->Paginator->sort('total_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($invoices as $invoice): ?>
	<tr>
		<td><?php echo h($invoice['Invoice']['invoice_number']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($invoice['User']['name'], array('controller' => 'users', 'action' => 'view', $invoice['User']['id'])); ?>
		</td>
		<td><?php echo h($invoice['Invoice']['date_invoiced']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['description']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['date_payment_received']); ?>&nbsp;</td>
		<td><?php echo h($invoice['Invoice']['total_amount']); ?>&nbsp;</td>
		<td><?php echo h($this->Custom->formatTimestamp($invoice['Invoice']['created'])); ?>&nbsp;</td>
		<td><?php echo h($this->Custom->formatTimestamp($invoice['Invoice']['modified'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $invoice['Invoice']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invoice['Invoice']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Invoice'), array('action' => 'add')); ?></li>
	</ul>
</div>
