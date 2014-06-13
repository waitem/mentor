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
<div class="users login">
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Reset your password - step 1'); ?></legend>
        <p>Have you forgotten your password? <br>Just enter a few details starting with your login email and we can reset your password.</p>
	<?php
		echo $this->Form->input('recover_account_email', array('label' => 'Email'));
                ?>
    </fieldset>
    <?php // put a container around the submit button and other stuff ?>
    <div>
        <div class="submit">
        <?php echo $this->Form->button(__('Next')); ?>
        </div>
        
        <div class="endtwocols"></div>
        

    </div>

<?php echo $this->Form->end();?>

</div>
