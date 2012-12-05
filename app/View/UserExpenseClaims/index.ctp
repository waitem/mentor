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
<div class="userExpenseClaims index">
	<h2>
            <?php echo $title_for_layout; ?>        
        </h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
                            
			<th><?php 
                        if ($showAll) {
                            echo $this->Paginator->sort('user_id');
                        }
                        ?></th>
                        <th><?php echo $this->Paginator->sort('date_claimed', 'Date');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>                        
			<th><?php echo $this->Paginator->sort('amount');?></th>
                        <th><?php echo __('Status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($userExpenseClaims as $userExpenseClaim): ?>
	<tr>
		<td>
			<?php 
                        if ($showAll) {
                        echo $this->Html->link($userExpenseClaim['User']['name'], array('controller' => 'users', 'action' => 'view', $userExpenseClaim['User']['id'])); 
                        }
                        ?>
		</td>
                <td><?php echo h($this->Custom->longDate( $userExpenseClaim['UserExpenseClaim']['date_claimed'])); ?>&nbsp;</td>
		<td><?php 
                if (strlen($userExpenseClaim['UserExpenseClaim']['description']) > 40 ) {
                    echo h(substr($userExpenseClaim['UserExpenseClaim']['description'], 0, 40) . ' ...');                     
                } else {
                    echo h($userExpenseClaim['UserExpenseClaim']['description']); 
                }
                ?>&nbsp;</td>
		<td style="text-align: right"><?php echo h($this->Number->currency($userExpenseClaim['UserExpenseClaim']['amount'])); ?>&nbsp;</td>

		<td><?php echo $this->element('UserExpenseClaims/reimbursed_status', array('view' => 'index', 'userExpenseClaim' => $userExpenseClaim))?>&nbsp;</td>

		<td class="actions">
                        <?php 
                        // Users can only edit their expenses if they have not yet been reimbursed
                        // Superiors can do everything
                        if ( ($userExpenseClaim['UserExpenseClaim']['user_id'] == $myUserId && ! $userExpenseClaim['UserExpenseClaim']['reimbursed'] ) ||
                                    in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))): ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userExpenseClaim['UserExpenseClaim']['id'])); ?>
                        <?php endif; ?>
                        <?php if ( ($userExpenseClaim['UserExpenseClaim']['user_id'] == $myUserId && $userExpenseClaim['UserExpenseClaim']['reimbursed'] ) ): ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userExpenseClaim['UserExpenseClaim']['id'])); ?>
                        <?php endif; ?>
                        <?php 
                        // only let the owner delete an expense claim
                        if ($userExpenseClaim['UserExpenseClaim']['user_id'] == $myUserId): ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userExpenseClaim['UserExpenseClaim']['id']), null, 
                                    __('Are you sure you want to delete this expense claim for %s?', 
                                            $userExpenseClaim['UserExpenseClaim']['amount'])); ?>
                        <?php endif; ?>
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
		<li><?php echo $this->Html->link(__('New Expense Claim'), array('action' => 'add')); ?></li>
	</ul>
</div>
