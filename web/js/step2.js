var pending = 0;
var tc = null;

function initStep2(tcInit) {
    // Init test cases object
    tc = tcInit;
    
    // Update test cases quantity pending
    pending = tc.quantity;
    
    // Update add matrix button
    updateAddMatrixButton();
    
    // Hide next step button
    $("#next-step").hide();
};

$("#matrix-add").on("click", function( event ) {
    // Get Matrix size value
    var matrixSize = $("#matrix-size").val();

    // Adds matrix to results panel and to test cases object
    addMatrix(matrixSize);

    // Get test cases left
    pending = pending - 1;

    // Change test cases remaining or hide add button
    if (pending == 0) {
        $('#matrix-add').hide();
        $("#next-step").show();
        $("#matrix-container").html("Done!");
    } else {
        updateAddMatrixButton();
    }
});

function updateAddMatrixButton()
{
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Matrix ("+pending+" left)");
}

function addMatrix(size)
{
    // Create Matrix object
    var mat = new Matrix(size, 0);
    
    // Add to test cases matrices collection
    tc.addMatrix(mat);
    
    // Add matrix to results panel
    var li = "<li class='list-group-item' size='"+size+"'>Matrix (1,1,1)...("+size+","+size+","+size+")</li>";
    $("#matrix-list").append(li);
}

$("#next-step").on('click', function( event ) {
    submitTestCase(tc);
});