var pending = 0;
var tc = null;

function initStep2(tcInit) {
    // Init test cases object
    tc = tcInit;
    
    // Update test cases quantity pending
    pending = tc.quantity;
    
    // Update add matrix operations button
    updateAddMatrixOperationsButton(pending);
    
    // Hide next step button
    $("#next-step").hide();
};

function updateAddMatrixOperationsButton(newSize)
{
    if (typeof newSize === 'undefined') {
        $("#matrix-container").html("Done!");
    } else {
        $("#matrix-size-label").html("Operations for matrix ("+newSize+", "+newSize+", "+newSize+"): ");
    }
}