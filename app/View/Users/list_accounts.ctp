<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
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
            
            echo '<th>' . $this->Paginator->sort( 'first_name' ). '</th>';
            echo '<th>' . $this->Paginator->sort( 'last_name', __('Surname')). '</th>';
        
            if ($roletype == 'Mentee') {
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
            }
        ?>                        
        <?php if ($myRoletypeName != 'Mentee'): ?>
            <th class="actions"><?php echo __('Actions');?></th>
        <?php endif; ?>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
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
                            <?php if (array_key_exists('paid', $this->params['named']) && $this->params['named']['paid'] == 'false'): ?>
                                <li><?php echo $this->Html->link(__('Mentee Accounts Paid'), array('controller' => 'users', 'action' => 'list_accounts', 'paid' =>  'true')); ?></li>
                            <?php else: ?>
                                <li><?php echo $this->Html->link(__('Mentee Accounts Unpaid'), array('controller' => 'users', 'action' => 'list_accounts', 'paid' =>  'false')); ?></li>
                            <?php endif; ?>
                <?php endif; ?>
                <?php echo '<li>' . $this->Html->link(__('Mentees'), array('controller' => 'users', 'action' => 'list_mentees')) . '</li>';  ?>
                    
	</ul>
</div>
