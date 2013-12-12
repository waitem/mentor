<div class="emailConfigs form">
<?php echo $this->Form->create('EmailConfig'); ?>
	<fieldset>
		<legend><?php echo $title_for_layout; ?></legend>
	<?php
                echo $this->Form->input('Tenant.id');
                echo $this->Form->input('Tenant.name', array('type' => 'hidden'));
                echo $this->Form->input('EmailConfig.id');
                ?>
                <div>
                    <div class="left twocols">
                <?php
		echo $this->Form->input('EmailConfig.name', array('label' => 'Email configuration name'));
		echo $this->Form->input('EmailConfig.from_email', array('label' => 'From address for outgoing e-mails'));
		echo $this->Form->input('EmailConfig.from_name');
                // Following two fields are not required - when using gmail they a
		echo $this->Form->input('EmailConfig.sender_email');
		echo $this->Form->input('EmailConfig.sender_name');
                ?>
                    </div>
                    <div class="right twocols">
                <?php
		echo $this->Form->input('EmailConfig.host_name');
		echo $this->Form->input('EmailConfig.host_port');
		echo $this->Form->input('EmailConfig.host_username');
		echo $this->Form->input('EmailConfig.host_password');
                
	?>
                        </div>
                    <div class="endtwocols"></div>
                </div>
                <?php echo $this->Form->input('Tenant.SendTestEmailTo', array('label' => 'Send a test e-mail to this address')); ?>
	</fieldset>
<?php echo $this->Form->end(__('Verify Email Configuration')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
                <li><?php echo  $this->Html->link(__('Dashboard'), array('controller' => 'users', 'action' => 'dashboard')); ?></li>
	</ul>
</div>
