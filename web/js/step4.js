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
    
    // Hide alert div
    $("#message").hide();
    
    // Hide next step button
    $("#next-step").hide();
};

$( "#matrix-add" ).on( "click", function( event ) {
    // Hide alert div
    $("#message").hide();
    
    $.post( 
        validateOperationsUrl, 
        { 
            commands: $("#matrix-operations").val(), 
            size: currentMatrix.size,
            operations: currentMatrix.operations,
        }, 
        function( data ) {
            if (data.errorCode != 0) {
                $("#message").html(data.errorString);
                $("#message").show();
            } else {
                $.each(data.data, function (elem) {
                    if (elem.type == "UPDATE") {
                        var operation = new UpdateOperation(elem.x, elem.y, elem.z, elem.value);
                    } else if (elem.type == "QUERY") {
                        var operation = new QueryOperation(elem.x1, elem.y1, elem.z1, elem.x2, elem.y2, elem.z2);
                    }
                    
                    // Add operation to current matrix
                    currentMatrix.addOperation(operation);
                });
                
                // Add matrix to test case
                tc.addMatrix(currentMatrix);
                
                // Add matrix to results panel
                addMatrixToResultsPanel();
                
                // Get next matrix
                currentMatrix = matrices.shift();
                
                // Change test cases remaining or hide add button
                if (typeof currentMatrix === 'undefined') {
                    $("#matrix-container").html("Done!");
                    $('#matrix-add').hide();
                    $("#next-step").show();
                } else {
                    // Update labels
                    updateCurrentMatrixLabel();
                    updateAddMatrixButton();
                }
            }
        }, 
    "json");
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

/**
 * Add matrix to results panel
 * 
 * @param {int} operations
 * 
 * @returns {void}
 */
function addMatrixToResultsPanel()
{
    // Add matrix to results panel
    var size = currentMatrix.size;
    var operations = currentMatrix.operations;
    
    var li = "<li class='list-group-item'>Matrix (1,1,1)...("+size+","+size+","+size+") => "+operations+" operations</li>"; 
    $("#matrix-list").append(li);
}