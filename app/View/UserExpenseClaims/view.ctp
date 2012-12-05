<?php
/*
 * Copyright (c) 2012 Mark Waite
 *
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<div class="userExpenseClaims view">
<h2><?php echo $title_for_layout;?>
        </h2>
	<dl>
                <?php if ($myUserId != $userExpenseClaim['UserExpenseClaim']['user_id']): ?>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userExpenseClaim['User']['name'], array('controller' => 'users', 'action' => 'view', $userExpenseClaim['User']['id'])); ?>
			&nbsp;
		</dd>
                <?php endif; ?>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($userExpenseClaim['UserExpenseClaim']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($userExpenseClaim['UserExpenseClaim']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Claimed'); ?></dt>
		<dd>
			<?php echo h($this->Custom->longDate($userExpenseClaim['UserExpenseClaim']['date_claimed'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo $this->element('UserExpenseClaims/reimbursed_status', array('view' => 'view', 'userExpenseClaim' => $userExpenseClaim)); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
		<li><?php echo $this->Html->link(__('Expense Claims'), array('action' => 'index')); ?> </li>
                <?php if (! $userExpenseClaim['UserExpenseClaim']['reimbursed']): ?>
                <li><?php echo $this->Html->link(__('Edit this Expense Claim'), array('action' => 'edit', $userExpenseClaim['UserExpenseClaim']['id'])); ?> </li>
                <?php endif; ?>
                <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userExpenseClaim['UserExpenseClaim']['id']), null, 
                                    __('Are you sure you want to delete this expense claim for %s?', 
                                            $userExpenseClaim['UserExpenseClaim']['amount'])); ?></li>
	</ul>
</div>
