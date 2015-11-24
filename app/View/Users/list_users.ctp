<?php
/*
 * Copyright (c) 2012-2015 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<div class="users dashboard">
    
	<h2><?php echo $title_for_layout ;?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <?php
            // This view/action can only be seen by Admins and Coordinators
            // (This is controlled in the UsersController::isAuthorized)
            
            echo '<th>' . $this->Paginator->sort( 'user_status_id', __('Status') ) . '</th>';
            echo '<th>' . $this->Paginator->sort( 'first_name' ). '</th>';
            echo '<th>' . $this->Paginator->sort( 'last_name', __('Surname')). '</th>';
        
            if ($roletype == 'Mentee') {
                $parentLabel = 'Mentor';
                foreach (array(
                        'mentee_date_joined', 
                        /* 'mentee_account_info', */
                ) as $element) {
                echo $this->element('Users/' . $element, 
                    array(
                        'view' => 'list_header',
                        'htmlHeader' => 'th',
                        'htmlDetail' => 'td',
                        )
                    );
                }
                if (array_key_exists('paid', $this->params['named']) ) {
                    foreach (array(
                            'mentee_account_info',
                            'mentee_chamber_account_info'
                    ) as $element) {
                    echo $this->element('Users/' . $element, 
                        array(
                            'view' => 'list_header',
                            'htmlHeader' => 'th',
                            'htmlDetail' => 'td',
                            )
                        );
                    }
                }
            } elseif ($roletype == 'Mentor') {
                $parentLabel = 'Coordinator';
                foreach (array(
                            'mentor_date_joined', 
                            'mentor_trained',
                            'mentor_max_mentees'
                    ) as $element) {
                    echo $this->element('Users/' . $element, 
                                    array(
                                        'view' => 'list_header',
                                        'htmlHeader' => 'th',
                                        'htmlDetail' => 'td',
                                        )
                                    );
                }
            } elseif ($roletype == 'Coordinator') {
                $parentLabel = 'Admin';
            } elseif ($roletype == 'Admin') {
                $parentLabel = 'Superadmin';
            }
        ?>                        
        <th><?php echo $this->Paginator->sort( 'ParentUser.name', $parentLabel);?></th>			
        <?php if ($myRoletypeName != 'Mentee'): ?>
            <th class="actions"><?php echo __('Actions');?></th>
        <?php endif; ?>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
                <?php echo $this->element('Users/status', array(
                		'view' => 'dashboard', 
                		'user' => $user, 
                		'htmlHeader' => 'th',
                		'htmlDetail' => 'td',
                )); ?>                
                <td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
                <td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
                <?php
                if ($roletype == 'Mentee') {
                foreach (array(
                        'mentee_date_joined', 
                        /* 'mentee_account_info', */
                    ) as $element) {
                echo $this->element('Users/' . $element,
                    array(
                        'user' => $user,
                        'view' => 'list_detail',
                        'htmlHeader' => 'th',
                        'htmlDetail' => 'td',
                        'newRoletypeName' => $user['Roletype']['name']
                        )
                    );
                    }
                    if (array_key_exists('paid', $this->params['named']) ) {
                        foreach (array(
                                'mentee_account_info',
                                'mentee_chamber_account_info'
                            ) as $element) {
                        echo $this->element('Users/' . $element,
                            array(
                                'user' => $user,
                                'view' => 'list_detail',
                                'htmlHeader' => 'th',
                                'htmlDetail' => 'td',
                                'newRoletypeName' => $user['Roletype']['name']
                                )
                            );
                            }                        
                    }
                } elseif ($roletype == 'Mentor') {
                foreach (array(
                        'mentor_date_joined', 
                        'mentor_trained',
                        'mentor_max_mentees'
                    ) as $element) {
                echo $this->element('Users/' . $element, 
                    array(
                        'user' => $user,
                        'view' => 'list_detail',
                        'htmlHeader' => 'th',
                        'htmlDetail' => 'td',
                        )
                    );
                }
                }
                ?>
                <?php 
                    echo $this->element('Users/parent_user_detail',
                    array(
                        'view' => 'list_users',
                        'htmlType' => 'td',
                        'user' => $user
                        )
                    );
                ?>
                                            
                <?php if ($myRoletypeName != 'Mentee'): ?>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
		</td>
                <?php endif; ?>
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
                <?php if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ): ?>
                	<?php if ($roletype == 'Mentee' || $roletype == 'Mentor') :?>
                		<li><?php echo $this->Html->link( $roletype . 's',
                				array('controller' => 'users', 'action' => strtolower($roletype) . 's_table')); ?></li>
                	<?php else :?>
	                    <li><?php echo $this->Html->link( __('Add') . ' ' . $roletype, 
	                            array('controller' => 'users', 'action' => 'add_' . strtolower($roletype) )); ?></li>
	                    <?php if (array_key_exists('active', $this->params['named']) && $this->params['named']['active'] == 'false'): ?>
	                    <li><?php echo $this->Html->link( __('Active') . ' ' . $roletype . 's', 
	                            array('controller' => 'users', 'action' => 'list_' . strtolower($roletype) . 's', 'active' =>  'true')); ?></li>
	                    <?php else: ?>
	                    <li><?php echo $this->Html->link( __('Inactive') . ' ' . $roletype . 's', 
	                            array('controller' => 'users', 'action' => 'list_' . strtolower($roletype) . 's', 'active' =>  'false')); ?></li>
	                    <li><?php echo $this->Html->link( __('Email') . ' ' . $roletype . 's', 
	                            array('controller' => 'users', 'action' => 'list_' . strtolower($roletype) . 's', 'email' => 'true')); ?></li>
	                    <?php endif; ?>
                    <?php endif;?>
                    <?php if ($roletype == 'Mentee'): ?>
                            <?php if (array_key_exists('paid', $this->params['named']) && $this->params['named']['paid'] == 'false'): ?>
                                <li><?php echo $this->Html->link(__('Mentee Accounts Paid'), array('controller' => 'users', 'action' => 'list_accounts', 'paid' =>  'true')); ?></li>
                            <?php else: ?>
                                <li><?php echo $this->Html->link(__('Mentee Accounts Unpaid'), array('controller' => 'users', 'action' => 'list_accounts', 'paid' =>  'false')); ?></li>
                            <?php endif; ?>
                    <li><?php echo $this->Html->link(__('Mentee Surveys'), array('controller' => 'mentee_surveys', 'action' => 'index')); ?></li>
                    <?php endif; ?>
                    
                <?php endif; ?>
                    
	</ul>
</div>
