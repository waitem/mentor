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
<div class="users view">
<h2><?php echo $title_for_layout ; ?></h2>
	<dl>
                <?php if ($myRoletypeName != 'Mentee'): ?>
                    <dt><?php echo __('Email'); ?></dt>
                    <?php
                    echo $this->element('Users/email_detail',
                        array(
                            'view' => 'view',
                            'htmlType' => 'dd'
                            )
                        );                    
                    ?>             
                    <dt><?php echo __('Phone Number'); ?></dt>
                    <dd>
                            <?php echo h($user['User']['phone_number']); ?>
                            &nbsp;
                    </dd>
                <?php endif; ?>
                <dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo h($user['Roletype']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Profile'); ?></dt>
		<dd>
			<?php echo nl2br(h($user['Profile']['notes'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
            <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
            <li><?php echo $this->Html->link(__('Profiles'), array('controller' => 'users', 'action' => 'index')); ?> </li>
	</ul>
</div>