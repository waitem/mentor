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
<div class="fullscreen">
<p>&nbsp;</p>
<p>Thank you for using the Business Mentors Web Application</p>

<p>You have now been successfully logged out</p>
<p>&nbsp;</p>
<p>This project has been assisted through the Sunshine Coast Council Grants Program.</p>

<?php echo $this->Html->link( 
        $this->Html->image('sponsors/scc.jpg', array('class' => 'sponsorimage')), 'http://www.sunshinecoast.qld.gov.au/',
        array('target' => '_blank', 'escape' => false)); ?>

<p>&nbsp;</p>
<p>We are also grateful for the support given to us by our sponsors:</p>

<p><?php echo $this->element('Pages/sponsors', array('view' => 'edit')); ?></p>

</div>
