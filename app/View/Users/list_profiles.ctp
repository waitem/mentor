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
<div class="users index">
	<h2><?php echo __('Profiles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
                        <?php if ($myRoletypeName == 'Superadmin'): ?>
                            <?php echo '<th>' . $this->Paginator->sort( 'tenant_id') . '</th>' ;?>
                        <?php endif; ?>
                        <th><?php echo $this->Paginator->sort( 'first_name' );?></th>
                        <th><?php echo $this->Paginator->sort( 'last_name', __('Surname'));?></th>
                        <th><?php echo $this->Paginator->sort( 'roletype_id', __('Role'));?></th>
                        <?php if ($myRoletypeName == 'Superadmin'): ?>
			<th><?php echo $this->Paginator->sort( 'parent_id');?></th>
                        <?php endif; ?>
                        <th><?php echo 'Profile';?></th>
			<th><?php echo __(' ');?></th>
	</tr>           
        
	<?php
	foreach ($users as $user): ?>
        
	<tr>
		<?php //Debugger::dump($user); ?>
                <?php if ($myRoletypeName == 'Superadmin'): ?>
			<?php echo '<td>' . $this->Html->link($user['Tenant']['name'], array('controller' => 'tenants', 'action' => 'view', $user['Tenant']['id'])) . '</td>'; ?>
                <?php endif; ?>
                <td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($user['Roletype']['name']); ?></td>
		<?php if ($myRoletypeName == 'Superadmin'): ?>
                    <td><?php echo $this->Html->link($user['ParentUser']['name'], 
                                array('controller' => 'users', 'action' => 'view', $user['ParentUser']['id'])); ?>
                    </td>
                <?php endif; ?>
                <td><?php 
                //echo strlen($user['Profile']['notes']);
                if (strlen($user['Profile']['notes']) > 50 ) {
                    echo h(substr($user['Profile']['notes'], 0, 50) . ' ...');                     
                } else {
                    echo h($user['Profile']['notes']); 
                }
                ?></td>


		<td>
			<?php echo $this->Html->link(__('View Profile'), array('action' => 'view_profile', $user['User']['id'])); ?>
                        <?php if ($myRoletypeName == 'Superadmin'): ?>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
	</ul>
</div>
