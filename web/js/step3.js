////////////////// VARIABLES //////////////////

/**
 * TestCases instance
 * 
 * @type TestCases
 */
var tc = null;

/**
 * Array of Matrix objects
 * 
 * @type Array of Matrix
 */
var matrices = new Array();

/**
 * Current matrix
 * 
 * @type Matrix
 */
var currentMatrix = null;

////////////////// EVENTOS //////////////////
 
/**
 * Init step 3
 * 
 * @param tcInit TestCases instance
 * 
 * @returns Void
 */ 
function initStep3(tcInit) {
    // Init test cases object
    tc = tcInit;
    
    // Init matrices
    matrices = tc.matrices;
    
    // Update current matrix
    currentMatrix = matrices.shift();
    
    // Clear matrices from test cases
    // They will be readded one by one with its operations
    tc.removeMatrices();
    
    // Update add matrix operations button
    updateAddMatrixOperationsLabel();
    
    // Update add matrix button
    updateAddMatrixButton();
    
    // Hide next step button
    $("#next-step").hide();
};

$( "#matrix-add" ).on( "click", function( event ) {
    // Get Matrix size operations value
    var operations = $("#matrix-size-operations").val();

    // Add matrix to test cases and to results panel
    addMatrix(operations);

    // Change test cases remaining or hide add button
    if (typeof currentMatrix === 'undefined') {
        $("#matrix-container").html("Done!");
        $('#matrix-add').hide();
        $("#next-step").show();
    } else {
        updateAddMatrixOperationsLabel();
        updateAddMatrixButton();
    }
});

$("#next-step").on('click', function( event ) {
    submitTestCase(tc);
});

////////////////// UI HELPERS //////////////////

function addMatrix(operations)
{
    addMatrixToResultsPanel(operations);
    addMatrixToTestCasesAndUpdateCurrent(operations);
}

function addMatrixToResultsPanel(operations)
{
    // Add matrix to results panel
    var size = currentMatrix.size;
    var li = "<li class='list-group-item'>Matrix (1,1,1)...("+size+","+size+","+size+") => "+operations+" operations</li>"; 
    $("#matrix-list").append(li);
}

function addMatrixToTestCasesAndUpdateCurrent(operations)
{
    
    // Add operations number to current matrix
    currentMatrix.operations = operations;
    
    // Add matrix to test cases instance
    tc.addMatrix(currentMatrix);

    // Update current instance
    currentMatrix = matrices.shift();
}

function updateAddMatrixOperationsLabel()
{
    var size = currentMatrix.size;
    $("#matrix-size-label").html("Operations for matrix ("+size+", "+size+", "+size+"): ");
}

function updateAddMatrixButton()
{
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Operations for Matrix ("+matrices.length+" left)");
}