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
function initStep4(tcInit) {
    // Init test cases object
    tc = tcInit;
    
    // Init matrices
    matrices = tc.matrices;
    
    // Update current matrix
    currentMatrix = matrices.shift();
    
    // Clear matrices from test cases
    // They will be readded one by one with its operations
    tc.removeMatrices();
    
    
    
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
