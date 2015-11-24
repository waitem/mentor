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
<div class="users">
    <div class="left button noprint">
        <?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?>
        <?php if (array_key_exists('inactive', $this->params['named']) && $this->params['named']['inactive'] == 'true' ) {
        	echo $this->Html->link(__('Active mentors'), array('controller' => 'users', 'action' => 'mentors_table'));
        } else {
			echo $this->Html->link(__('Inactive mentors'), array('controller' => 'users', 'action' => 'mentors_table', 'inactive' => 'true'));
		}?>
	</div>
    <div class="button right noprint">
            <?php if (!(array_key_exists('inactive', $this->params['named']) && $this->params['named']['inactive'] == 'true' )) : ?>
        	<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'list_mentors', 'email' => 'true')); ?>">E-Mail Mentors</a>
        	            <?php 
            if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
            		echo $this->Html->link( __('Add') . ' ' . $roletype, 
                            array('controller' => 'users', 'action' => 'add_' . strtolower($roletype) )); 
			}
			?>
			<?php endif;?>
    </div>
    <div class="endtwocols"></div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
            <?php
            // This view/action can only be seen by Admins and Coordinators
            // (This is controlled in the UsersController::isAuthorized)
            
            echo '<th>' . $this->Paginator->sort( 'UserStatus.number', 'Status' ) . '</th>';
            echo '<th>' . $this->Paginator->sort( 'first_name' ). '</th>';
            echo '<th>' . $this->Paginator->sort( 'last_name', __('Surname')). '</th>';
        
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
        ?>                        
        <th><?php echo $this->Paginator->sort( 'ParentUser.name', $parentLabel);?></th>			
        <?php if ($myRoletypeName != 'Mentee'): ?>
            <th class="actions"><?php echo __('Actions');?></th>
        <?php endif; ?>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
				<?php echo $this->element('Users/status', array('view' => 'dashboard', 'htmlDetail' => 'td', 'user' => $user )); ?>                
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