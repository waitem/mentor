<?php
/*
 * Copyright (c) 2012 Mark Waite
 */
?>
<div class="menteeSurveys form">
<?php echo $this->Form->create('MenteeSurvey');?>
	<fieldset>
		<legend><?php echo ucfirst($this->action) . ' a ' . __('Mentee Survey'); ?></legend>
	<?php
		echo $this->Form->input('user_id', array('label' => 'Mentee'));
		echo $this->Form->input('date_sent',
                        array(
                           'class'=>'datepicker', 
                           'type'=>'text'
                        ));
                echo '<div class="showHideDate">';
		echo $this->Form->input('returned');
		echo $this->Form->input('date_returned',
                        array(
                           'class'=>'datepicker', 
                           'type'=>'text'
                        ));
                echo '</div>';
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
		<li><?php echo $this->Html->link(__('Mentee Surveys'), array('action' => 'index'));?></li>
	</ul>
</div>
