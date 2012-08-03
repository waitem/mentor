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
<div class="users view">
    <div class="left">
        <h2>
            <?php echo $title_for_layout ; ?>
        </h2>
        </div>
    <div class="button right noprint">
        <a href="javascript:window.print()">Print</a>
    </div>
    <div class="endtwocols"></div>
	<dl>
            <?php 
            // Don't show our own "active" status - if we aren't active
            // we wouldn't be able to log in!
            if ($myUserId != $user['User']['id']) {
               echo $this->element('Users/active', array(
                   'view' => 'view' ,
                   'user' => $user['User']
                   )
               );
            }
            ?>

                <?php
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator','Mentor' ) ) ) {
                    if ($user['Roletype']['name'] == 'Mentee') {
                        foreach (array(
                                    'mentee_date_joined',
                                    'mentee_statement_of_purpose_sent',
                                    'mentee_waiver_form_signed',
                            ) as $element) {
                        echo $this->element('Users/' . $element, 
                            array(
                                'view' => 'view',
                                'newRoletypeName' => $user['Roletype']['name'],
                                'htmlHeader' => 'dt',
                                'htmlDetail' => 'dd',
                                )
                            );
                        };
                    };
                };
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    if ($user['Roletype']['name'] == 'Mentee') {
                        foreach (array(
                                    'mentee_account_info',
                            ) as $element) {
                        echo $this->element('Users/' . $element, 
                            array(
                                'view' => 'view',
                                'newRoletypeName' => $user['Roletype']['name'],
                                'htmlHeader' => 'dt',
                                'htmlDetail' => 'dd',
                                )
                            );
                        };
                    };
                };
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) 
                        // Let the mentor see their details
                        || $myUserId == $user['User']['id']) {
                    if ($user['Roletype']['name'] == 'Mentor') {
                        foreach (array(
                                    'mentor_date_joined', 
                                    'mentor_agreement_signed',
                                    'mentor_trained',
                            ) as $element) {
                            echo $this->element('Users/' . $element, 
                                array(
                                    'view' => 'view',
                                    'htmlHeader' => 'dt',
                                    'htmlDetail' => 'dd',
                                    )
                                );
                        }
                    }
                };
                ?>
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
                <?php echo $this->element('Users/address',
                    array(
                        'view' => 'view',
                        'htmlType' => 'dd'
                        )
                    );
                ?>    
                <?php echo $this->element('Users/mentee_company',
                    array(
                        'view' => 'view',
                        'htmlType' => 'dd'
                        )
                    );
                ?>    
                <dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo h($user['Roletype']['name']); ?>
			&nbsp;
		</dd>
                <?php   
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) 
                        || $myUserId == $user['User']['id']) {
                    if ($user['Roletype']['name'] == 'Mentor') {
                        echo $this->element('Users/mentor_max_mentees', 
                                array(
                                    'view' => 'view',
                                    'htmlHeader' => 'dt',
                                    'htmlDetail' => 'dd',
                                    )
                                );
                    }
                }
                echo $this->element('Users/parent_user_header',
                    array(
                        'view' => 'view',
                        'htmlType' => 'dt'
                        )
                    );                    
                echo $this->element('Users/parent_user_detail',
                    array(
                        'view' => 'view',
                        'htmlType' => 'dd'
                        )
                    );              
                ?>
		<dt><?php echo __('Profile'); ?></dt>
		<dd><div class="profile">
			<?php echo nl2br( h($user['Profile']['notes']) ); ?>
                        </div>
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
            <?php 
            // if we are on our "home" screen ...
            if ($myUserId == $user['User']['id']): ?>
                <li><?php echo $this->Html->link(__('Edit my details'), array('action' => 'edit', $user['User']['id'])); ?> </li>
                <li><?php echo $this->Html->link(__('Change my password'), array('action' => 'change_password', $user['User']['id'])); ?> </li>
                <?php if (in_array( $myRoletypeName, array( 'Coordinator', 'Mentor', 'Mentee') ) ): ?>                
                    <li><?php echo $this->Html->link(__('Manage dates I\'m away'), array('controller' => 'user_away_dates', 'action' => 'index')); ?> </li>
                <?php endif; ?>
                <?php if (in_array( $myRoletypeName, array( 'Coordinator', 'Mentor') ) ): ?>
                    <li><?php echo $this->Html->link(__('Expense Claims'), array('controller' => 'user_expense_claims', 'action' => 'index')) ?> </li>
                <?php endif; ?>
            <?php else: ?>
            <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
            <?php
                // Mentees can't edit anyone else
                // Others can only edit descendents
                if ($myRoletypeName != 'Mentee' && $myRoletypeId < $user['User']['roletype_id']) {
                    echo '<li>' . $this->Html->link(__('Edit') . ' ' . $user['User']['first_name'] . '\'s details', 
                        array('action' => 'edit', $user['User']['id'])) . '</li>';
                    echo '<li>' . $this->Html->link(__('Change') . ' ' . $user['User']['first_name'] . '\'s password', 
                        array('action' => 'change_password', $user['User']['id'])) . '</li>';
                }
            ?>
            <?php endif; ?>

            <?php
                echo $this->element('Users/admin_actions');
            ?>
            <?php // if we are on our "home" screen ... and not a mentee ...
            if ($myRoletypeName != 'Mentee' && $myUserId == $user['User']['id']): ?>
            <li><?php echo $this->Html->link(__('Profiles'), array('controller' => 'users', 'action' => 'index')); ?> </li>
            <?php endif; ?>
	</ul>
</div>
        <?php 
        // Don't show "children" of mentees (there aren't any) and
        // Don't show "children" of anyone if the logged in user is a mentee and
        // Don't show other mentors if logged in as a mentor
        if ($canViewChildren):
            ?>	
	<div class="related">
            
	<h3><?php 
        if ($user['Roletype']['name'] == 'Mentor')
            echo __('Mentees');
        elseif ($user['Roletype']['name'] == 'Coordinator') {
            echo __('Mentors');
        } elseif ($user['Roletype']['name'] == 'Admin') {
            echo __('Coordinators');
        } else {
            echo __('Related Users');
        }
        ?></h3>
        <?php if (!empty($user['ChildUser'])):?>	
	<table cellpadding = "0" cellspacing = "0">
	<tr>                
                <?php //echo $this->element('Users/active', array('view' => 'list_header')); ?>
                <th><?php echo __('Name'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['ChildUser'] as $childUser): ?>
		<tr>
                       <?php //echo $this->element('Users/active', array('view' => 'list_detail', 'user' => $childUser )); ?>
                        <td><?php echo $this->Html->link($childUser['name'], array('controller' => 'users', 'action' => 'view', $childUser['id'])); ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div> <?php // class ="related" ?>
<?php endif; ?>

        <?php if (!empty($userAwayDates)):?>	
	<div class="related">
            
	<h3><?php
            echo __('Dates when') . ' ';
            if ($myUserId == $user['User']['id']) {
                echo 'I\'m ';
            } else {
                echo $user['User']['first_name'] . ' is ';
            }
            
            echo __('away/unavailable');
        ?></h3>

	<table cellpadding = "0" cellspacing = "0">
	<tr>
                <th><?php echo __('First Day Away'); ?></th>
		<th><?php echo __('Last Day Away'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($userAwayDates as $userAwayDate): ?>
		<tr>
                        <td><?php echo h($this->Custom->longDate( $userAwayDate['UserAwayDate']['first_day_away'])); ?>&nbsp;</td>
                        <td><?php echo h($this->Custom->longDate( $userAwayDate['UserAwayDate']['last_day_away'])); ?>&nbsp;</td>
		</tr>
	<?php endforeach; ?>
	</table>


    </div>
<?php endif; ?>