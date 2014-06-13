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
<div class="userAwayDates form">
<?php echo $this->Form->create('UserAwayDate');?>
	<fieldset>
            <legend><?php echo $title_for_layout; ?></legend>
	<?php
		echo $this->Form->input('user_id',
                        array('type' => 'hidden')
                        );
		echo $this->Form->input('first_day_away',
                        array(
                           'class'=>'datepicker', 
                           'type'=>'text'
                        )
                    );
		echo $this->Form->input('last_day_away',
                        array(
                           'class'=>'datepicker', 
                           'type'=>'text'
                        )
                    );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'view', $myUserId)); ?></li>
                <?php echo '<li>' . $this->Html->link(__('Manage dates I\'m away'), array('controller' => 'user_away_dates', 'action' => 'index')) . '</li>'; ?>
	</ul>
</div>
