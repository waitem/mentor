/*
 * Copyright (c) 2012 Mark Waite
 *
 * Author(s): See AUTHORS.txt
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 */
$(document).ready(function() {
    $( "input.datepicker" ).dp({
       dateFormat: 'dd/mm/yy', 
       altFormat: 'yy-mm-dd'
    }); 
    
    //<div id="flashMessage" class="success">Your details have been updated</div>
    $("div#flashMessage").each(function() {
        if ($(this).hasClass('success')) {
            $(this).delay(1500).hide(500);
        }
    });
});