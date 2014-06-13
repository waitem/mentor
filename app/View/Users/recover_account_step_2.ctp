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
        <legend><?php echo __('Reset your password - step 2'); ?></legend>
        <p>OK, nearly there. Now we just need your postcode.</p>
	<?php
		echo $this->Form->input('recover_account_email', array('type' => 'hidden'));
                echo $this->Form->input('UserAddress.recover_account_postcode', array('label' => 'Your postcode'));
                ?>
        <p>After you click on the button below, a new password will be sent to you by email</p>
    </fieldset>
    <?php // put a container around the submit button and other stuff ?>
    <div>
        <div class="submit">
        <?php echo $this->Form->button(__('Reset my password')); ?>
        </div>
        
        <div class="endtwocols"></div>
        

    </div>

<?php echo $this->Form->end();?>

</div>
