<div class="invoices view">
<h2><?php  echo __('Invoice'); ?></h2>
	<dl>
		<dt><?php echo __('Invoice Number'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['invoice_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoice['User']['name'], array('controller' => 'users', 'action' => 'view', $invoice['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Invoiced'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['date_invoiced']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Payment Received'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['date_payment_received']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Amount'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['total_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Custom->formatTimestamp($invoice['Invoice']['created'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Custom->formatTimestamp($invoice['Invoice']['modified'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
		<li><?php echo $this->Html->link(__('Mentees'), array('controller' => 'users', 'action' => 'mentees_table')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Invoice'), array('action' => 'edit', $invoice['Invoice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('action' => 'add')); ?> </li>
	</ul>
</div>
