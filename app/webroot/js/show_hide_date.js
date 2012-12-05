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


// Catch a click on a checkbox within a <div class="showHideDate">
$("div.showHideDate div.checkbox input:nth-child(2)").click(function(){
        
    if ($(this).is(':checked')) {
        $(this).parent().parent().find("div:nth-child(2)").show(200);
    } else {
        $(this).parent().parent().find("div:nth-child(2)").hide();
    }
});

// This is run once on the page if a <div class="showHideDate"> is found
$("div.showHideDate").each(function() {

    if ($(this).find("div input:nth-child(2)").is(':checked')) {
        $(this).find("div:nth-child(2)").show(200);
    } else {
        $(this).find("div:nth-child(2)").hide();
    }

});

});