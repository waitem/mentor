<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 * This version: Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
            <?php if ($this->Session->check('Tenant.name')): ?>
                <?php echo SessionHelper::read('Tenant.name'). __(' Business Mentors') ; ?>
            <?php else: ?>
                <?php echo __('Business Mentors Data Management System'); ?>
            <?php endif; ?>
            <?php echo ': ' . $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('mentor.generic');
                echo $this->Html->css('mentor.print', null, array( 'media' => 'print'));

                 //load up the jQuery core
                echo $this->Html->css('jquery-ui/jquery-ui');
                echo $this->Html->script('jquery.min');
                echo $this->Html->script('jquery-ui.min');
                echo $this->Html->script('datepicker');
                echo $this->Html->script('mentor');
                echo $this->Html->script('show_hide_date');
                echo $this->element('googleAnalytics');
		echo $scripts_for_layout;
	?>
</head>
<body>
    <!-- This software program is Copyright (c) 2012, IT MaD  -->
	<div id="container">
		<div id="header" class="left">
                    <h1><?php if ($this->Session->check('Tenant.name')): ?>
                        <?php echo $this->Session->read('Tenant.name'). ' ' . __('Business Mentors') ; ?>
                        <?php else: ?>
                        <?php echo __('Business Mentors Data Management System'); ?>
                    <?php endif; ?></h1>
                </div>
                
                <div id="header" class="right">
                    <h1 align="right">
                    <?php 
                        
                    if ($this->Session->check('Auth.User.name')) {
                        echo $this->Html->link(
                                $this->Session->read('Auth.User.name'),
                                array('controller'=>'users','action'=>'view', $myUserId)
                                );
                        echo ' | ';
                        echo $this->Html->link('Logout', array('controller'=>'users','action'=>'logout'));
                    } else {
                         if ( $this->request['controller'] . '/' . $this->request['action'] != 'users/login' ) {
                             echo $this->Html->link('Login', array('controller'=>'users','action'=>'login'));
                         }
                    } ?>
                    </h1>
		</div>
            
		<div id="content">

			<?php echo $this->Session->flash(); ?>
                        <?php echo $this->Session->flash('auth'); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
                    <?php echo $this->Html->link('Mentor application', 'https://github.com/waitem/mentor', array('target' => '_blank')) ;
                        echo ' ';
                        echo 'version ' . Configure::read('Mentor.version');;
                        echo ' | ';
			echo __('Copyright (c) 2012 ') . $this->Html->link('Noosa Chamber of Commerce and Industry', 'http://noosachamber.com.au', array('target' => '_blank'));
                        echo ' | ';
                        echo $this->Html->link('Terms of Use', array('controller'=>'pages','action'=>'terms_of_use'), array('target' => '_blank'));
                                ?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
    <?php 
    // See http://book.cakephp.org/2.0/en/core-libraries/helpers/js.html for why following line is there
    //echo $this->Js->writeBuffer(); // Write cached scripts  
    ?>
</body>
</html>
