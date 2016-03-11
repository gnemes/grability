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

/**
 * Validate operations URL
 * 
 * @type String
 */
var validateOperationsUrl = "";

////////////////// EVENTOS //////////////////
 
/**
 * Init step 3
 * 
 * @param tcInit TestCases instance
 * 
 * @returns Void
 */ 
function initStep4(tcInit, validateOperationsUrlInit) {
    // Set validate operations URL
    validateOperationsUrl = validateOperationsUrlInit;
            
    // Init test cases object
    tc = tcInit;
    
    // Init matrices
    matrices = tc.matrices;
    
    // Update current matrix
    currentMatrix = matrices.shift();
    
    // Clear matrices from test cases
    // They will be readded one by one with its operations
    tc.removeMatrices();
    
    // Update labels
    updateCurrentMatrixLabel();
    updateAddMatrixButton();
    
    // Hide next step button
    $("#next-step").hide();
};

$( "#matrix-add" ).on( "click", function( event ) {
    $.post( validateOperationsUrl, { operations: $("#matrix-operations").val() }, function( data ) {
       dump(data);
    }, "json");
    
    /*
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
    */
});

$("#next-step").on('click', function( event ) {
    submitTestCase(tc);
});

////////////////// UI HELPERS //////////////////

/**
 * Updates matrix label with current matrix
 * 
 * @returns {void}
 */
function updateCurrentMatrixLabel()
{
    var size = currentMatrix.size;
    var text = 'Enter operations for Matrix (1,1,1)...('+size+','+size+','+size+')';
    $("#matrix-operations-label").html(text);
}

/**
 * Update add matrix button with matrix remain quantity
 * 
 * @returns {void}
 */
function updateAddMatrixButton()
{
    // Change label to button Add Matrix
    $("#matrix-add").html("Add Operations for Matrix ("+matrices.length+" left)");
}

