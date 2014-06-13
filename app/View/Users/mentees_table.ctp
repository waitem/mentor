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
<div class="users">
		<div class="left button noprint">
        <?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?>
        <?php if (array_key_exists('inactive', $this->params['named']) && $this->params['named']['inactive'] == 'true' ) {
        	echo $this->Html->link(__('Active mentees'), array('controller' => 'users', 'action' => 'mentees_table'));
        } else {
			echo $this->Html->link(__('Inactive mentees'), array('controller' => 'users', 'action' => 'mentees_table', 'inactive' => 'true'));
		}?>
        </div>
    <div class="right button noprint">
        <?php if (!(array_key_exists('inactive', $this->params['named']) && $this->params['named']['inactive'] == 'true' )) : ?>
    	<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'list_mentees', 'email' => 'true')); ?>">E-Mail Mentees</a>
        <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'mentees_csv')); ?>">Download CSV</a>
        <?php //		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">  ?>
        <?php if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
	            echo $this->Html->link( __('Add') . ' ' . $roletype, 
                      array('controller' => 'users', 'action' => 'add_' . strtolower($roletype) ));
        } 
		?>
		<?php endif;?>
		<?php //		</span></button> ?>
    </div>
    <div class="endtwocols"></div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<?php
			// This view/action can only be seen by Admins and Coordinators
			// (This is controlled in the UsersController::isAuthorized)

			echo '<th>' . $this->Paginator->sort( 'UserStatus.number', 'Status' ) . '</th>';
			echo '<th>' . $this->Paginator->sort( 'name', 'Mentee' ). '</th>';
			echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.company_name', "Company" ). '</th>';
			//echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.date_statement_of_purpose_sent', "Contacted" ). '</th>';
			//echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.date_joined', "Joined" ). '</th>';

			$parentLabel = 'Mentor';
			foreach (array(
					'mentee_statement_of_purpose_sent',
					'mentee_date_joined',
					//'mentee_account_info'
			) as $element) {
				echo $this->element('Users/' . $element,
                    array(
                        'view' => 'list_header',
                        'htmlHeader' => 'th',
                        'htmlDetail' => 'td',
						// take the first user to provide info needed by element
						'user' => $users[0]
                        )
                    );
			}
			
			echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.invoice_number', "Invoice" ). '</th>';
			echo '<th>' . $this->Paginator->sort( 'MenteeExtraInfo.date_invoiced', "Sent" ). '</th>';
			
			echo $this->element('Users/mentee_invoice_paid',
					array(
							'view' => 'list_header',
							'htmlHeader' => 'th',
							'htmlDetail' => 'td',
							// take the first user to provide info needed by element
							'user' => $users[0]
					)
			);
			?>
			<th><?php echo $this->Paginator->sort( 'ParentUser.name', $parentLabel);?>
			</th>
			<?php if ($myRoletypeName != 'Mentee'): ?>
			<th class="actions"><?php echo __('Actions');?></th>
			<?php endif; ?>
		</tr>
		<?php
	foreach ($users as $user): ?>
		<tr>
			<?php echo $this->element('Users/status', array('view' => 'dashboard', 'htmlDetail' => 'td', 'user' => $user )); ?>
			<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
			<td><?php echo h($user['MenteeExtraInfo']['company_name']); ?>&nbsp;</td>
			<?php
			if ($roletype == 'Mentee') {
				foreach (array(
						'mentee_statement_of_purpose_sent',
						'mentee_date_joined',
						//'mentee_account_info',
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
				?>
				<td><?php echo h($user['MenteeExtraInfo']['invoice_number']); ?>&nbsp;</td>
				<?php 
				foreach (array(
						'mentee_invoice_sent',
						'mentee_invoice_paid',
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
			}
                ?>
			<?php
			foreach (array(
					'parent_user_detail',
					// 'email_detail'
			) as $element) {
				echo $this->element('Users/' . $element,					
                    array(
                        'view' => 'list_users',
                        'htmlType' => 'td',
                        'user' => $user
                        )
                    );
			}
                ?>

			<?php if ($myRoletypeName != 'Mentee'): ?>
			<td class="actions"><?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
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
	?>
	</p>

	<div class="paging">
		<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
