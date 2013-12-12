<div class="audits index">
	<h2><?php echo __('Audit Log'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
                        <th><?php echo $this->Paginator->sort('created', 'When'); ?></th>
                        <th><?php echo $this->Paginator->sort('source_id', 'Who'); ?></th>
                        <th><?php echo $this->Paginator->sort('UserAffected.name', 'Changes made'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($audits as $audit): ?>
	<tr>                
		<td><?php echo h($this->Custom->formatTimestamp($audit['Audit']['created'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($audit['ChangedBy']['name'], array('controller' => 'users', 'action' => 'view', $audit['Audit']['source_id'])); ?>
		</td>                
                <td>
                        <?php echo $this->Html->link($audit['UserAffected']['name'], array('controller' => 'users', 'action' => 'view', $audit['Audit']['user_id'])); ?>
                        <?php if (!empty($audit['AuditDelta'])): ?>
                            <?php
                                    $i = 0;
                                    foreach ($audit['AuditDelta'] as $auditDelta): ?>
                                            <?php if (in_array($auditDelta['property_name'], 
                                                    array('last_login', 'last_logout')
                                                    )) {
                                                echo 'logged ' . substr($auditDelta['property_name'], 8);
                                            } else {
                                                echo '<br>';
                                                echo '"' . $auditDelta['property_name'] . '" changed from ';
                                                echo '"' . $auditDelta['old_value'] . '" to ';
                                                echo '"' . $auditDelta['new_value'] . '"'; 
                                            }
                                            ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link('View', array('action' => 'view', $audit['Audit']['id'])); ?>
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
