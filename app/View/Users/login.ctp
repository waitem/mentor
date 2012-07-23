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
<div class="users login">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Login'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
	?>
	</fieldset>
    <div class="submit">
        <?php echo $this->Form->button(__('Login')); ?>
        </div>
    <div class="right" style="text-align: left;width:350px;font-size: 70%">
        <p>By clicking the "Login" button you agree that you have read and agree with the 
            <?php echo $this->Html->link('Terms of Use', array('controller'=>'pages','action'=>'terms_of_use'), array('target' => '_blank')); ?>
 of this application</p></div>
        <div class="endtwocols"></div>
<?php echo $this->Form->end();?>

</div>
