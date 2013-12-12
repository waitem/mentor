<div class="audits view">

<h2><?php  echo __('Audit Log Entry No. ') . h($audit['Audit']['id']); ?></h2>
	<dl>
		<dt><?php echo __('At'); ?></dt>
		<dd>
			<?php echo h($this->Custom->formatTimestamp($audit['Audit']['created'])); ?>
			&nbsp;
		</dd>

                <dt><?php echo __('Who'); ?></dt>
		<dd>
			<?php echo $this->Html->link($audit['ChangedBy']['name'], array('controller' => 'users', 'action' => 'view', $audit['Audit']['source_id'])); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo $this->Html->link($audit['UserAffected']['name'], array('controller' => 'users', 'action' => 'view', $audit['Audit']['user_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('What'); ?></dt>
		<dd>
			<?php echo h($audit['Audit']['event']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Model'); ?></dt>
		<dd>
			<?php echo h($audit['Audit']['model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entity Id'); ?></dt>
		<dd>
			<?php echo h($audit['Audit']['entity_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Json Object'); ?></dt>
		<dd>
			<?php echo h($audit['Audit']['json_object']); ?>
			&nbsp;
		</dd>
	</dl>
<div class="related">
	<h3><?php echo __('Changes made:'); ?></h3>
        <?php /* 
         * FIXME: if audit event is EDIT then show deltas
         *  if CREATE then show json_object 
         */
                ?>
	<?php if (!empty($audit['AuditDelta'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Field'); ?></th>
		<th><?php echo __('Old Value'); ?></th>
		<th><?php echo __('New Value'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($audit['AuditDelta'] as $auditDelta): ?>
		<tr>
			<td><?php echo $auditDelta['property_name']; ?></td>
			<td><?php echo $auditDelta['old_value']; ?></td>
			<td><?php echo $auditDelta['new_value']; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
		<li><?php echo $this->Html->link(__('Audit Log'), array('action' => 'index')); ?> </li>
	</ul>
</div>
