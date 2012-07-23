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
<div class="users form">
    <?php echo $this->Form->create('User');?>

		<h2>
                    <?php 
                    echo $title_for_layout;
                    ?>
                </h2>
	<fieldset>
        <script>
        	$(function() {
		$( "#tabs" ).tabs({
			event: "mouseover"
		});
	});
	</script>

	<?php
        
                // Needed to ensure that the data is kept if the form
                // fails to save
                echo $this->Form->input('User.id', array('type' => 'hidden'));                                    
                echo $this->Form->input('User.name', array('type' => 'hidden'));

                echo $this->element('Users/active', array('view' => 'edit'));
                ?>
                <div id="tabs">
                    <ul>
                    <li><a href="#tabs-1">Personal details</a></li>
                    <?php if (in_array($this->action, array('add_admin', 'add_coordinator', 'add_mentor', 'add_mentee'))): ?>
                    <li><a href="#tabs-2">Password</a></li>
                    <?php endif; ?>
                    <?php 
                    // only Mentors and Mentees have extra info
                    if (in_array($user['User']['roletype_id'], array(MENTOR, MENTEE))) : ?>
                    <li><a href="#tabs-3"><?php echo $newRoletypeName . ' data'?></a></li>
                    <?php endif; ?>
                    <li><a href="#tabs-4">Public profile</a></li>
                    </ul>
                <div id="tabs-1" class="tab">
                <div class="left twocols">
                <?php
                // Only a superadmin can change their own Tenant (at the moment ...)
                if ($myRoletypeName == 'Superadmin' && $myUserId == $user['User']['id']) {
                    echo $this->Form->input('tenant_id');
                } else {
                    echo $this->Form->input('tenant_id', array('type' => 'hidden'));
                }
                // Needed to ensure that the data is kept if the form
                // fails to save
                echo $this->Form->input('roletype_id', array('type' => 'hidden'));

                // Only let Admins and coordinators change an existing user's name
                // or the mentor/mentee extra info
                // But if adding a user, we also need to prompt for their name
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ||
                        $this->action == 'add') {
                    echo $this->Form->input('first_name');
                    echo $this->Form->input('last_name');
                } else {
                    echo $this->Form->input('first_name', array('type' => 'hidden'));
                    echo $this->Form->input('last_name', array('type' => 'hidden'));
                }                
                echo $this->Form->input('email');
		echo $this->Form->input('phone_number');
                ?>
                        </div>                
                <div class="right twocols">         
                    <?php
                        echo $this->element('Users/address', 
                            array(
                                'view' => 'edit',
                                )
                            );
                    ?>
                </div>
                <?php // the next div is needed to put the above "floating" left
                      //and right column divs back in the enclosing (tab) div 
                ?>
                <div class="endtwocols"></div> 
                </div>  <?php // personal details ?>
                <?php if (in_array($this->action, array('add_admin', 'add_coordinator', 'add_mentor', 'add_mentee'))) {
                    echo '<div id="tabs-2" class="tab">';
                    echo $this->Form->input('new_password',array('type'=>'password'));
                    // Additional field for password verification...
                    echo $this->Form->input('password_confirmation',array('type'=>'password'));
                    echo "</div>";
                }
                ?>
                <?php
                // only Mentors and Mentees have extra info
                if (in_array($user['User']['roletype_id'], array(MENTOR, MENTEE))) {
                    echo '<div id="tabs-3" class="tab">';
                    echo '<div class="left twocols">';
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    // Instead of $user['Roletype']['name'] we use $user['User']['roletype_id']
                    if ($user['User']['roletype_id'] == MENTEE) {
                        echo $this->element('Users/mentee_date_joined', 
                            array(
                                'view' => 'edit',
                                )
                            );
                    } elseif ($user['User']['roletype_id'] == MENTOR) { 
                        echo $this->element('Users/mentor_date_joined',                                     
                                array(
                                    'view' => 'edit',
                                    )
                                );
                    }
                    // Only let Admins and coordinators see/change the parent during editing
                    // someone else. But allow it when adding a new user
                    if ($myUserId != $user['User']['id'] ||
                        $this->action == 'add') {
                        echo $this->Form->input('parent_id', array('options' => $parentUsers,
                            'label' => $parentRoletypeName
                            ));
                    } else {
                        echo $this->Form->input('parent_id', array('type' => 'hidden'));
                    }
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) 
                        // Mentors can edit how many mentees they want
                        || $myUserId == $user['User']['id']) {
                        if ($user['User']['roletype_id'] == MENTOR) {
                            echo $this->element('Users/mentor_max_mentees', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                        }
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) ) 
                        // The mentee can edit their company
                        || $myUserId == $user['User']['id']) {
                    if ($user['User']['roletype_id'] == MENTEE) {
                        echo $this->element('Users/mentee_company', 
                            array(
                                'view' => 'edit',
                                )
                            );
                    }
                }
                // only Mentors and Mentees have extra info
                if (in_array($user['User']['roletype_id'], array(MENTOR, MENTEE))) {                        
                    echo '</div>';
                    echo '<div class="right twocols">';
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                        if ($user['User']['roletype_id'] == MENTEE) {
                            echo $this->element('Users/mentee_statement_of_purpose_sent', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                            echo $this->element('Users/mentee_waiver_form_signed', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                            echo $this->element('Users/mentee_account_info', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                        }
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
                    if ($user['User']['roletype_id'] == MENTOR) {
                        echo $this->element('Users/mentor_agreement_signed', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                        echo $this->element('Users/mentor_trained', 
                                array(
                                    'view' => 'edit',
                                    )
                                );
                    }
                }
                // only Mentors and Mentees have extra info
                if (in_array($user['User']['roletype_id'], array(MENTOR, MENTEE))) {                        
                        echo '</div>';
                        // the next div is needed to put the above "floating" left
                        //and right column divs back in the enclosing (tab) div 
                        echo '<div class="endtwocols"></div>';
                        echo '</div>';
                }
                echo '<div id="tabs-4" class="tab">';
                echo $this->Form->input('Profile.id');
                echo $this->Form->input('Profile.notes', array('label' => false,'class' => 'profile'));
                echo "</div>";
                ?>
                </div>   <?php // end of tabs div ?>
	</fieldset>
    <div class="submit">
    <?php if (in_array($this->action, array('add_admin', 'add_coordinator', 'add_mentor', 'add_mentee'))) {
        $buttonText = 'Add this ' . $newRoletypeName;
    } else {
        if ($myUserId == $user['User']['id']) {
            $buttonText = 'Update my details';            
        } else {
            $buttonText = 'Update ' . $user['User']['first_name'] . '\'s details';            
        }
    }
    echo $this->Form->button($buttonText);
    ?>

        </div>
<?php echo $this->Form->end();?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <?php if (in_array($this->action, array('modify', 'edit'))): ?>
                <?php if (array_key_exists( 'id', $user['User']) && $myUserId == $user['User']['id']) {
                    $person = 'my';
                } else {
                    $person =  $user['User']['first_name'] . '\'s';
                } ?>
                <li><?php echo $this->Html->link( 'View ' . $person . ' details', array('action' => 'view', $user['User']['id'])); ?></li>
                <li><?php echo $this->Html->link( 'Change ' . $person . ' password', array('action' => 'change_password', $user['User']['id'])); ?></li>
                <?php endif; // $this->action == 'edit' ?>
                <?php echo $this->element('Users/admin_actions'); ?>
	</ul>
</div>
