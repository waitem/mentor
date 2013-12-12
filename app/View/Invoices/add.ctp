<div class="invoices form">
	<?php echo $this->Form->create('Invoice'); ?>
	<fieldset>
		<legend>
			<?php echo __('Add Invoice'); ?>
		</legend>
		<?php
		echo $this->Form->input('invoice_number');
		echo $this->Form->input('user_id');
		echo $this->Form->input('date_invoiced',
				array(
						'class'=>'datepicker',
						'type'=>'text'
				));
		echo $this->Form->input('description');
		echo $this->Form->input('date_payment_received',
				array(
					'class'=>'datepicker',
					'type'=>'text'
				));
		echo $this->Form->input('total_amount');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3>
		<?php echo __('Actions'); ?>
	</h3>
	<ul>
        <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index')); ?>
		</li>
	</ul>
</div>
