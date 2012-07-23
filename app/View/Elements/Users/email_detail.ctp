<?php
/*
 * Copyright (c) 2012 Noosa Chamber of Commerce and Industry
 * 
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
    if (in_array($view, array('dashboard', 'view'))) {
        echo "<$htmlType>";
        echo $user['User']['email'] . ' ' . $this->Html->link('E', 'mailto:' . $user['User']['email'], 
                // if opening in browser (e.g. chrome) then open in a new window
                array('target' => '_blank')  );
        echo "</$htmlType>";
    } else {
        echo "Hmmm, not sure what I should be showing here. Please fix Elements/Users/email_detail.ctp";
    }
?>
