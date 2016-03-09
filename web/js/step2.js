var pending = 0;
var tc = null;

function initStep2(tcInit) {
    tc = tcInit;
    
    pending = tc.quantity;
    
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Matrix ("+pending+" left)");
    
    // Hide next step button
    $("#next-step").hide();
};
