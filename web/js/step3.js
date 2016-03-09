var pending = 0;
var tc = null;
var matrices = null;
var currentMatrix = null;

function initStep2(tcInit) {
    // Init test cases object
    tc = tcInit;
    
    // Init matrices
    matrices = tc.matrices;
    
    // Update current matrix
    currentMatrix = matrices.shift();
    
    // Update test cases quantity pending
    pending = tc.quantity;
    
    // Update add matrix operations button
    updateAddMatrixOperationsButton(currentMatrix.size);
    
    // Update add matrix button
    updateAddMatrixButton();
    
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

$("#next-step").on('click', function( event ) {
    submitTestCase(tc);
});

function updateAddMatrixButton()
{
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Operations for Matrix ("+pending+" left)");
}