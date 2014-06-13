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
<div class="users form">
	<?php // novalidate => true disables the html5 validation of "required" fields 
		// which we don't want on this screen because some required fields might be 
		// hidden in another tab, and therefore the user won't see the error message
		// from the browser 
		?>
	<?php echo $this->Form->create('User', array('novalidate' => true));?>

	<h2>
		<?php echo $title_for_layout; ?>
	</h2>
	<fieldset>
		<script>
        	$(function() {
		$( "#tabs" ).tabs({
			event: "click"
		});
	});
	</script>

		<?php

		// Needed to ensure that the data is kept if the form
		// fails to save
		echo $this->Form->input('User.id', array('type' => 'hidden'));
		echo $this->Form->input('User.name', array('type' => 'hidden'));

		echo $this->element('Users/status', array('view' => 'edit'));
		?>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-10">Personal details</a></li>
				<?php // only Mentees have extra info
		if ($user['User']['roletype_id'] == MENTEE ) {
							if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) ) ) { ?>
				<li><a href="#tabs-50">Meeting notes</a></li>
				<?php
							}
						} else { ?>
				<li><a href="#tabs-50">Public profile</a></li>
				<?php } ?>

				<?php  // ADMIN TAB
                    // only Mentors and Mentees have an Admin tab
                    // which is only visible to Coordinators and above
                    // And the mentor can see selected fields of his own Admin tab
                    if ((in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) )  &&
                            $myRoletypeId < $user['User']['roletype_id']) ||
                        ($user['User']['roletype_id'] == MENTOR &&
                                         $myUserId == $user['User']['id']) ) : ?>
				<li><a href="#tabs-30"><?php echo 'Administration'?> </a></li>
				<?php endif; ?>
				<?php // Extra tab for mentee account info
                    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) )  &&
                        $user['User']['roletype_id'] == MENTEE ) : ?>
				<li><a href="#tabs-40">Accounting</a></li>
				<?php endif; ?>
			</ul>
			<?php // PERSONAL DETAILS ?>
			<div id="tabs-10" class="tab">
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
                // Mentees have extra info
                if ($user['User']['roletype_id'] == MENTEE &&
					(in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) )
					// The mentee can edit their company
					|| $myUserId == $user['User']['id'])) {
					echo $this->Form->input('MenteeExtraInfo.company_web_site', array('label' => 'Company Web Site (without the "http://" bit)'));
				}
				?>
				</div>
				<div class="right twocols">
					<?php // MENTEE INFO ?>
					<?php
					// Mentees have extra info
					if ($user['User']['roletype_id'] == MENTEE) {
                    if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) )
                            // The mentee can edit their company
                            || $myUserId == $user['User']['id']) {
						echo $this->Form->input('MenteeExtraInfo.id');
						echo $this->Form->input('MenteeExtraInfo.company_name');
                    }
                }
                ?>
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
			</div>
			<?php // personal details ?>
			<?php  // PROFILE TAB
                    if ($user['User']['roletype_id'] == MENTEE) {
                	if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator', 'Mentor' ) ) ) {
						echo '<div id="tabs-50" class="tab">';
						echo $this->Form->input('MenteeExtraInfo.additional_info', array('label' => false, 'class' => 'profile'));
						echo "</div>";
					}
				} else {
					echo '<div id="tabs-50" class="tab">';
					echo $this->Form->input('Profile.id');
					echo $this->Form->input('Profile.notes', array('label' => false, 'class' => 'profile'));
					echo "</div>";
				}
				?>
			<?php // ADMIN TAB 
				// Superadmins, admins and coordinators get to see the admin tab for all users with lower roles
				if ((in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) )  &&
						$myRoletypeId < $user['User']['roletype_id']) ||
						($user['User']['roletype_id'] == MENTOR &&
								$myUserId == $user['User']['id']) ) {

					echo '<div id="tabs-30" class="tab">';
					echo '<div class="left twocols">';

					if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
						// Instead of $user['Roletype']['name'] we use $user['User']['roletype_id']
						if ($user['User']['roletype_id'] == MENTEE) {
							echo $this->element('Users/mentee_hear_about',
                            array(
                                'view' => 'edit',
                                )
                            );
							echo $this->element('Users/mentee_statement_of_purpose_sent',
									array(
											'view' => 'edit',
									)
							);
							echo $this->element('Users/mentee_date_joined',
									array(
											'view' => 'edit',
									)
							);
							echo $this->element('Users/mentee_waiver_form_signed',
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
                // only Mentors and Mentees have extra info
                if (in_array($user['User']['roletype_id'], array(MENTOR, MENTEE))) {
                    echo '</div>';
                    echo '<div class="right twocols">';
                }
                if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) {
					// Only let Admins and coordinators see/change the parent during editing
					// someone else. But allow it when adding a new user
					if ($myUserId != $user['User']['id'] ||
					$this->action == 'add') {
						echo $this->Form->input('parent_id', array('options' => $parentUsers,
								'label' => $parentRoletypeName
						));
						if ($user['User']['roletype_id'] == MENTEE) {
							echo $this->element('Users/mentee_second_mentor',
									array(
											'view' => 'edit',
											// Pass the array of mentors and a lable to use
											'element_params' => array(
													'options' => $secondMentors,
													'label' => 'Second mentor (optional)'
											)
									)
							);
						}
					} else {
						echo $this->Form->input('parent_id', array('type' => 'hidden'));
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

                echo '</div>';
                // the next div is needed to put the above "floating" left
                //and right column divs back in the enclosing (tab) div
                echo '<div class="endtwocols"></div>';
                echo '</div>';
				}
				// Mentee account info
				if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) )  &&
                        $user['User']['roletype_id'] == MENTEE ) {
                    echo '<div id="tabs-40" class="tab">';
                    echo '<div class="left twocols">';
                    echo $this->element('Users/mentee_account_info',
                        array(
                            'view' => 'edit',
                            )
                        );
                    echo '</div>';
                    echo '<div class="right twocols">';
                    /*
						Mentee chamber account info used to be here
					*/
                    echo '</div>';
                    // the next div is needed to put the above "floating" left
                    //and right column divs back in the enclosing (tab) div
                    echo '<div class="endtwocols"></div>';
                    echo '</div>';
                }
                ?>
		</div>
		<?php // end of tabs div ?>
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
	<h3>
		<?php echo __('Actions'); ?>
	</h3>
	<ul>
		<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?>
		</li>
		<?php if (in_array($this->action, array('modify', 'edit'))): ?>
		<?php if (array_key_exists( 'id', $user['User']) && $myUserId == $user['User']['id']) : ?>
		<li><?php echo $this->Html->link( 'View my details', array('action' => 'view', $user['User']['id'])); ?>
		</li>
		<li><?php echo $this->Html->link( 'Change my password', array('action' => 'change_password', $user['User']['id'])); ?>
		</li>
		<?php else :?>
		<?php $person =  $user['User']['first_name'] . '\'s'; ?>
		<li><?php echo $this->Html->link( 'View ' . $person . ' details', array('action' => 'view', $user['User']['id'])); ?>
		</li>
		<?php if (in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) ) ) :?>
		<li><?php echo $this->Html->link( 'Reset ' . $person . ' password', array('action' => 'reset_password', $user['User']['id'])); ?>
		</li>
		<?php endif; // in_array( $myRoletypeName, array( 'Superadmin', 'Admin', 'Coordinator' ) )  ?>
		<?php endif; // $this->action == 'edit' ?>
		<?php endif; // $this->action == 'edit' ?>
		<?php echo $this->element('Users/admin_actions'); ?>
	</ul>
</div>
