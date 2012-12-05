<?php
/*
 * Copyright (c) 2012 Mark Waite
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<div class="userExpenseClaims form">
<?php echo $this->Form->create('UserExpenseClaim');?>
	<fieldset>
		<legend><?php echo $title_for_layout; ?></legend>
	<?php
                echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('user_id', array('type' => 'hidden'));
                echo $this->Form->input('User.name', array('type' => 'hidden'));
                echo $this->Form->input('date_claimed', array('type' => 'hidden'));
                /* if ($this->action == 'add') {                  
                    echo $this->Form->input('date_claimed',
                            array(
                                'class'=>'datepicker', 
                                'type'=>'text'
                             )
                    );
                } else { */
                    echo '<div class="input text area">';
                    echo '<label>Date Claimed</label>';
                    echo h($this->Custom->longDate($this->request->data['UserExpenseClaim']['date_claimed']));
                    echo '</div>';
                //}
                // We can add, but we only edit our own expenses if they have not been reimbursed ...
                if ($this->action == 'add' ||
                        ( $myUserId == $this->request->data['UserExpenseClaim']['user_id'] &&
                            $this->request->data['UserExpenseClaim']['reimbursed'] == false )
                   ) {
                    echo $this->Form->input('description');
                    echo $this->Form->input('amount');
                } else {
                    echo '<div class="input text area">';
                    echo '<label>Description</label>';
                    echo h($this->request->data['UserExpenseClaim']['description']);
                    echo '</div>';
                    echo $this->Form->input('description', array('type' => 'hidden'));
                    echo '<div class="input text area">';
                    echo '<label>Amount Claimed</label>';
                    echo h($this->Number->currency($this->request->data['UserExpenseClaim']['amount']));
                    echo '</div>';
                    echo $this->Form->input('amount', array('type' => 'hidden'));
                }
                
                // Only coordinators upwards can edit the reimbursed status
                if ($this->action == 'edit' &&
                        in_array($myRoletypeName, array('Superadmin', 'Admin', 'Coordinator'))) {
                    echo '<div class="showHideDate">';
                    echo $this->Form->input('reimbursed');
                    echo $this->Form->input('date_reimbursed',
                    array(
                        'class'=>'datepicker', 
                        'type'=>'text'
                     )
                    );
                    echo '</div>';
                } else {
                    // Because this field is hidden, we need to allow it to be "empty" in the
                    // validation rules
                    echo $this->Form->input('reimbursed', array('type' => 'hidden'));
                    echo $this->Form->input('date_reimbursed', array('type' => 'hidden'));
                }
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
		<li><?php echo $this->Html->link(__('Expense Claims'), array('action' => 'index'));?></li>
	</ul>
</div>
