/* global tc */
var pending = tc.quantity;

$(function() {
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Matrix ("+pending+" left)");
    
    // Hide next step button
    $("#next-step").hide();
});
